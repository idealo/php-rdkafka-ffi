<?php

declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\ConsumerTopic
 * @covers \RdKafka\Topic
 */
class ConsumerTopicTest extends TestCase
{
    /**
     * @group ffiOnly
     */
    public function testGetCData()
    {
        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $cData = $topic->getCData();

        $this->assertInstanceOf(CData::class, $cData);
    }

    public function testGetName()
    {
        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $name = $topic->getName();

        $this->assertEquals(KAFKA_TEST_TOPIC, $name);
    }

    public function testConsume()
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeStart(0, rd_kafka_offset_tail(1));

        $message = $consumerTopic->consume(0, (int)KAFKA_TEST_TIMEOUT_MS);

        $consumerTopic->consumeStop(0);

        $this->assertEquals(__METHOD__, $message->payload);
    }

    public function testConsumeWithInvalidPartitionShouldFail()
    {
        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $consumerTopic->consume(-2, (int)KAFKA_TEST_TIMEOUT_MS);
    }

    public function testConsumeCallback()
    {
        $consumedMessage = null;

        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('consume.callback.max.messages', (string)1);

        $producer = new Producer($conf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $consumer = new Consumer($conf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeStart(0, rd_kafka_offset_tail(1));

        $callback = function (Message $message, $opaque = null) use (&$consumedMessage) {
            $consumedMessage = $message;
        };
        $messagesConsumed = $consumerTopic->consumeCallback(0, (int)KAFKA_TEST_TIMEOUT_MS, $callback);

        $consumerTopic->consumeStop(0);

        $this->assertEquals(1, $messagesConsumed);
        $this->assertEquals(__METHOD__, $consumedMessage->payload);
    }

    public function testConsumeBatch()
    {
        $batchSize = 1000;

        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        for ($i = 0; $i < $batchSize; $i++) {
            $producerTopic->produce(0, 0, __METHOD__ . $i);
        }
        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeStart(0, rd_kafka_offset_tail($batchSize));

        $messages = $consumerTopic->consumeBatch(0, (int)KAFKA_TEST_TIMEOUT_MS, $batchSize);

        $consumerTopic->consumeStop(0);

        $this->assertCount($batchSize, $messages);
        for ($i = 0; $i < $batchSize; $i++) {
            $this->assertEquals(__METHOD__ . $i, $messages[$i]->payload);
        }

        unset($consumerTopic);
        unset($consumer);
    }

    public function testConsumeBatchWithInvalidPartitionShouldFail()
    {
        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $consumerTopic->consumeBatch(-2, (int)KAFKA_TEST_TIMEOUT_MS, 1);
    }

    public function testConsumeBatchWithInvalidBatchSizeShouldFail()
    {
        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/batch_size/');
        $consumerTopic->consumeBatch(0, (int)KAFKA_TEST_TIMEOUT_MS, 0);
    }

    public function testConsumeQueueStart()
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $queue = $consumer->newQueue();
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $consumerTopic->consumeQueueStart(0, rd_kafka_offset_tail(1), $queue);
        $message = $queue->consume((int)KAFKA_TEST_TIMEOUT_MS);
        $consumerTopic->consumeStop(0);

        $this->assertEquals(__METHOD__, $message->payload);
    }

    public function testConsumeStartWithInvalidPartitionShouldFail()
    {
        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $queue = $consumer->newQueue();
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $consumerTopic->consumeQueueStart(-2, 0, $queue);
    }

    public function testOffsetStore()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . rand(0, 99999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('enable.auto.offset.store', 'false');
        $conf->set('enable.auto.commit', 'true');
        $conf->set('auto.commit.interval.ms', '50');

        $highLevelConsumer = new KafkaConsumer($conf);

        $topicPartitions = $highLevelConsumer->getCommittedOffsets(
            [new TopicPartition(KAFKA_TEST_TOPIC, 0)],
            (int)KAFKA_TEST_TIMEOUT_MS
        );
        $this->assertEquals(-1001, $topicPartitions[0]->getOffset());

        $consumer = new Consumer($conf);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
        $topic->consume(0, 50);

        $topic->offsetStore(0, 4);

        $topic->consumeStop(0);

        $topicPartitions = $highLevelConsumer->getCommittedOffsets(
            [new TopicPartition(KAFKA_TEST_TOPIC, 0)],
            (int)KAFKA_TEST_TIMEOUT_MS
        );
        $this->assertEquals(5, $topicPartitions[0]->getOffset());
    }

    public function testOffsetStoreWithInvalidPartitionShouldFail()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . rand(0, 99999999));
        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $topic->offsetStore(-111, 0);
    }
}
