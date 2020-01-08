<?php

declare(strict_types=1);

namespace RdKafka;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \RdKafka\KafkaConsumer
 * @covers \RdKafka\Conf
 * @covers \RdKafka\Exception
 * @covers \RdKafka\TopicPartition
 * @covers \RdKafka\TopicPartitionList
 */
class KafkaConsumerTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        // produce two messages
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(RD_KAFKA_PARTITION_UA, 0, 'payload-kafka-consumer-1');
        $producerTopic->produce(RD_KAFKA_PARTITION_UA, 0, 'payload-kafka-consumer-2');
        $producer->flush((int) KAFKA_TEST_TIMEOUT_MS);
    }

    public function testConstructWithMissingGroupIdConfShouldFail(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/group\.id/');

        new KafkaConsumer(new Conf());
    }

    public function testAssign(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->assign(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
                new TopicPartition(KAFKA_TEST_TOPIC_PARTITIONS, 2),
            ]
        );

        $topicPartitions = $consumer->getAssignment();

        $this->assertCount(2, $topicPartitions);
        $this->assertSame(KAFKA_TEST_TOPIC, $topicPartitions[0]->getTopic());
        $this->assertSame(0, $topicPartitions[0]->getPartition());
        $this->assertSame(KAFKA_TEST_TOPIC_PARTITIONS, $topicPartitions[1]->getTopic());
        $this->assertSame(2, $topicPartitions[1]->getPartition());
    }

    public function testAssignWithNullShouldClearAssignment(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->assign(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ]
        );

        $this->assertCount(1, $consumer->getAssignment());

        $consumer->assign();

        $this->assertCount(0, $consumer->getAssignment());
    }

    public function testSubscribe(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe(
            [
                KAFKA_TEST_TOPIC,
                KAFKA_TEST_TOPIC_PARTITIONS,
            ]
        );

        $topicPartitions = $consumer->getSubscription();

        $this->assertCount(2, $topicPartitions);
        $this->assertSame(KAFKA_TEST_TOPIC, $topicPartitions[0]);
        $this->assertSame(KAFKA_TEST_TOPIC_PARTITIONS, $topicPartitions[1]);
    }

    public function testUnsubscribe(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe(
            [
                KAFKA_TEST_TOPIC,
            ]
        );

        $topicPartitions = $consumer->getSubscription();

        $this->assertCount(1, $consumer->getSubscription());

        $consumer->unsubscribe();

        $this->assertCount(0, $consumer->getSubscription());
        $this->assertSame(KAFKA_TEST_TOPIC, $topicPartitions[0]);
    }

    public function testConsume(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 999999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('auto.offset.reset', 'earliest');

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        // wait for partition assignment
        sleep(1);

        $lastMessage = $message = null;
        while (true) {
            $message = $consumer->consume((int) KAFKA_TEST_TIMEOUT_MS);
            if ($message->err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
                if ($lastMessage === null) {
                    continue;
                }
                $message = $lastMessage;
                break;
            }
            $lastMessage = $message;
        }

        $this->assertInstanceOf(Message::class, $message);
        $this->assertSame('payload-kafka-consumer-2', $message->payload);

        $message = $consumer->consume(0);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertSame(RD_KAFKA_RESP_ERR__TIMED_OUT, $message->err);

        $consumer->unsubscribe();
    }

    public function testCommitWithInvalidArgumentShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/\bcommit\b/');
        $this->expectExceptionMessageMatches('/array/');
        $consumer->commit([new stdClass()]);
    }

    public function testCommitAsyncWithInvalidArgumentShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/commitAsync\b/');
        $this->expectExceptionMessageMatches('/object/');
        $consumer->commitAsync(new stdClass());
    }

    public function testCommitWithMessage(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 999999999));
        $conf->set('enable.auto.commit', 'false');
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('auto.offset.reset', 'earliest');

        $offset = 0;

        $conf->setOffsetCommitCb(
            function (KafkaConsumer $kafka, int $err, array $topicPartitions, $opaque = null) use (&$offset): void {
                $offset = $topicPartitions[0]->getOffset();
            }
        );

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        // wait for partition assignment
        sleep(1);

        $lastMessage = $message = null;
        while (true) {
            $message = $consumer->consume((int) KAFKA_TEST_TIMEOUT_MS);
            if ($message->err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
                if ($lastMessage === null) {
                    continue;
                }
                $message = $lastMessage;
                break;
            }
            $lastMessage = $message;
        }
        $consumer->commit($lastMessage);

        // just trigger callback
        $consumer->consume((int) KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame($message->offset + 1, $offset);

        $consumer->unsubscribe();
    }

    public function testCommitWithOffsetAndMetadata(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 999999999));
        $conf->set('enable.auto.commit', 'false');
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('auto.offset.reset', 'earliest');

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        // wait for partition assignment
        sleep(1);

        $consumer->commit([new TopicPartition(KAFKA_TEST_TOPIC, 0, 1, 'metadata')]);

        $topicPartitions = $consumer->getCommittedOffsets(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ],
            (int) KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertSame(1, $topicPartitions[0]->getOffset());
        $this->assertSame('metadata', $topicPartitions[0]->getMetadata());

        $consumer->unsubscribe();
    }

    public function testCommitAsyncWithOffset(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('enable.auto.commit', 'false');

        $consumer = new KafkaConsumer($conf);
        $consumer->commitAsync([new TopicPartition(KAFKA_TEST_TOPIC, 0, 2)]);

        sleep(2);

        $topicPartitions = $consumer->getCommittedOffsets(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ],
            (int) KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertSame(2, $topicPartitions[0]->getOffset());
    }

    public function testGetCommittedOffsets(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 999999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('auto.offset.reset', 'earliest');

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        $topicPartitions = $consumer->getCommittedOffsets(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ],
            (int) KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertSame(-1001 /*RD_KAFKA_OFFSET_INVALID*/, $topicPartitions[0]->getOffset());

        $consumed = 0;
        while ($consumed < 2) {
            $message = $consumer->consume((int) KAFKA_TEST_TIMEOUT_MS);
            if ($message->err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
                continue;
            }
            $consumer->commit($message);
            $consumed++;
        }

        $topicPartitions = $consumer->getCommittedOffsets(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ],
            (int) KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertSame(2, $topicPartitions[0]->getOffset());
    }

    public function testOffsetsForTimesWithFutureTimestamp(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 999999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);

        $future = (int) (time() + 3600) * 1000;

        $consumer = new KafkaConsumer($conf);
        $topicPartitions = $consumer->offsetsForTimes(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0, $future),
            ],
            (int) KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertSame(-1 /* no offsets in the future */, $topicPartitions[0]->getOffset());
    }

    public function testOffsetsForTimesWithNearNowTimestamp(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 999999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);

        $nearNow = (int) (time()) * 1000;

        // produce two messages
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(RD_KAFKA_PARTITION_UA, 0, 'offsetsForTimes1');
        $producerTopic->produce(RD_KAFKA_PARTITION_UA, 0, 'offsetsForTimes2');
        $producer->flush((int) KAFKA_TEST_TIMEOUT_MS);

        $consumer = new KafkaConsumer($conf);
        $topicPartitions = $consumer->offsetsForTimes(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0, $nearNow),
            ],
            (int) KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertGreaterThan(1, $topicPartitions[0]->getOffset());
    }

    public function testOffsetsForTimesWithAncientTimestamp(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 999999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);

        $past = 0;

        $consumer = new KafkaConsumer($conf);
        $topicPartitions = $consumer->offsetsForTimes(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0, $past),
            ],
            (int) KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertSame(0, $topicPartitions[0]->getOffset());
    }

    public function testGetMetadata(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $conf->set('metadata.broker.list', KAFKA_BROKERS);

        $consumer = new KafkaConsumer($conf);

        $metadata = $consumer->getMetadata(true, null, (int) KAFKA_TEST_TIMEOUT_MS);

        $this->assertInstanceOf(Metadata::class, $metadata);
    }

    public function testNewTopic(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $conf->set('metadata.broker.list', KAFKA_BROKERS);

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->assertInstanceOf(KafkaConsumer::class, $consumer);
        $this->assertInstanceOf(KafkaConsumerTopic::class, $topic);
    }
}
