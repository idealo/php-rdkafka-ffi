<?php

declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\ConsumerTopic
 * @covers \RdKafka\Topic
 * @covers \RdKafka\FFI\ConsumeCallbackProxy
 */
class ConsumerTopicTest extends TestCase
{
    /**
     * @group ffiOnly
     */
    public function testGetCData(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumer = new Consumer($conf);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $cData = $topic->getCData();

        $this->assertInstanceOf(CData::class, $cData);
    }

    public function testGetName(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumer = new Consumer($conf);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $name = $topic->getName();

        $this->assertSame(KAFKA_TEST_TOPIC, $name);
    }

    public function testConsume(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $consumerConf = new Conf();
        $consumerConf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumer = new Consumer($consumerConf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeStart(0, rd_kafka_offset_tail(1));

        $message = $consumerTopic->consume(0, KAFKA_TEST_TIMEOUT_MS);

        $consumerTopic->consumeStop(0);

        $this->assertSame(__METHOD__, $message->payload);
    }

    public function testConsumeWithInvalidPartitionShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumer = new Consumer($conf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $consumerTopic->consume(-2, KAFKA_TEST_TIMEOUT_MS);
    }

    public function testConsumeCallback(): void
    {
        $consumed = new class() {
            public ?Message $message = null;
        };

        $producerConf = new Conf();
        $producerConf->set('bootstrap.servers', KAFKA_BROKERS);

        $producer = new Producer($producerConf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producerTopic->produce(0, 0, __METHOD__);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $consumerConf = new Conf();
        $consumerConf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumerConf->set('consume.callback.max.messages', (string) 3);
        $consumerConf->set('enable.partition.eof', 'false');

        $consumer = new Consumer($consumerConf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeStart(0, rd_kafka_offset_tail(3));

        // note: seems to buggy since librdkafka 1.8.0 (even with ext) first call returns 1 but does not call the callback
        $callback = function (Message $message, $opaque = null) use ($consumed): void {
            $consumed->message = $message;
        };
        do {
            $messagesConsumed = $consumerTopic->consumeCallback(0, KAFKA_TEST_TIMEOUT_MS, $callback);
        } while ($consumed->message === null);

        $consumerTopic->consumeStop(0);

        $this->assertSame(3, $messagesConsumed);
        $this->assertSame(__METHOD__, $consumed->message->payload);
    }

    /**
     * @group ffiOnly
     */
    public function testConsumeCallbackWithOpaque(): void
    {
        $expectedOpaque = new \stdClass();

        $consumed = new class() {
            public ?Message $message = null;
            public ?object $opaque = null;
        };

        $producerConf = new Conf();
        $producerConf->set('bootstrap.servers', KAFKA_BROKERS);

        $consumerConf = new Conf();
        $consumerConf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumerConf->set('consume.callback.max.messages', (string) 1);

        $producer = new Producer($producerConf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $consumer = new Consumer($consumerConf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeStart(0, rd_kafka_offset_tail(1));

        $callback = function (Message $message, $opaque = null) use ($consumed): void {
            $consumed->message = $message;
            $consumed->opaque = $opaque;
        };

        do {
            $messagesConsumed = $consumerTopic->consumeCallback(0, KAFKA_TEST_TIMEOUT_MS, $callback, $expectedOpaque);
        } while ($consumed->message === null);

        $consumerTopic->consumeStop(0);

        $this->assertSame(1, $messagesConsumed);
        $this->assertSame(__METHOD__, $consumed->message->payload);
        $this->assertSame($expectedOpaque, $consumed->opaque);
    }

    public function testConsumeBatch(): void
    {
        $batchSize = 1000;

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        for ($i = 0; $i < $batchSize; $i++) {
            $producerTopic->produce(0, 0, __METHOD__ . $i);
        }
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $consumer = new Consumer($conf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeStart(0, rd_kafka_offset_tail($batchSize));

        $messages = $consumerTopic->consumeBatch(0, KAFKA_TEST_TIMEOUT_MS, $batchSize);

        $consumerTopic->consumeStop(0);

        $this->assertCount($batchSize, $messages);
        for ($i = 0; $i < $batchSize; $i++) {
            $this->assertSame(__METHOD__ . $i, $messages[$i]->payload);
        }

        unset($consumerTopic);
        unset($consumer);
    }

    public function testConsumeBatchWithInvalidPartitionShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumer = new Consumer($conf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $consumerTopic->consumeBatch(-2, KAFKA_TEST_TIMEOUT_MS, 1);
    }

    public function testConsumeBatchWithInvalidBatchSizeShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumer = new Consumer($conf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/batch_size/');
        $consumerTopic->consumeBatch(0, KAFKA_TEST_TIMEOUT_MS, 0);
    }

    public function testConsumeQueueStart(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $consumer = new Consumer($conf);
        $queue = $consumer->newQueue();
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $consumerTopic->consumeQueueStart(0, rd_kafka_offset_tail(1), $queue);
        $message = $queue->consume(KAFKA_TEST_TIMEOUT_MS);
        $consumerTopic->consumeStop(0);

        $this->assertSame(__METHOD__, $message->payload);
    }

    public function testConsumeStartWithInvalidPartitionShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumer = new Consumer($conf);
        $queue = $consumer->newQueue();
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $consumerTopic->consumeQueueStart(-2, 0, $queue);
    }

    public function testOffsetStore(): void
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);
        $conf->set('group.id', __METHOD__ . random_int(0, 99999999));
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->set('enable.auto.offset.store', 'false');
        $conf->set('enable.auto.commit', 'true');
        $conf->set('auto.commit.interval.ms', '50');
        $conf->set('topic.metadata.refresh.interval.ms', (string) 900);

        $highLevelConsumer = new KafkaConsumer($conf);

        $topicPartitions = $highLevelConsumer->getCommittedOffsets(
            [new TopicPartition(KAFKA_TEST_TOPIC, 0)],
            KAFKA_TEST_TIMEOUT_MS
        );
        $this->assertSame(-1001, $topicPartitions[0]->getOffset());

        $consumer = new Consumer($conf);

        // wait for meta data refresh
        sleep(1);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
        $topic->consume(0, 50);

        $topic->offsetStore(0, 4);

        $topic->consumeStop(0);

        $topicPartitions = $highLevelConsumer->getCommittedOffsets(
            [new TopicPartition(KAFKA_TEST_TOPIC, 0)],
            KAFKA_TEST_TIMEOUT_MS
        );
        $this->assertSame(5, $topicPartitions[0]->getOffset());
    }

    public function testOffsetStoreWithInvalidPartitionShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 99999999));
        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $topic->offsetStore(-111, 0);
    }
}
