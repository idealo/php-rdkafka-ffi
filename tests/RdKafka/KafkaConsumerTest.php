<?php

declare(strict_types=1);

namespace RdKafka;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \RdKafka\KafkaConsumer
 * @covers \RdKafka\Conf
 * @covers \RdKafka\TopicPartition
 * @covers \RdKafka\TopicPartitionList
 */
class KafkaConsumerTest extends TestCase
{
    static public function setUpBeforeClass(): void
    {
        // produce two messages
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(RD_KAFKA_PARTITION_UA, 0, 'payload-kafka-consumer-1');
        $producerTopic->produce(RD_KAFKA_PARTITION_UA, 0, 'payload-kafka-consumer-2');
        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);
    }

    public function testConstructWithMissingGroupIdConfShouldFail()
    {
        $this->expectException(Exception::class);
        $this->expectDeprecationMessageMatches('/group\.id/');

        new KafkaConsumer(new Conf());
    }

    public function testAssign()
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
        $this->assertEquals(KAFKA_TEST_TOPIC, $topicPartitions[0]->getTopic());
        $this->assertEquals(0, $topicPartitions[0]->getPartition());
        $this->assertEquals(KAFKA_TEST_TOPIC_PARTITIONS, $topicPartitions[1]->getTopic());
        $this->assertEquals(2, $topicPartitions[1]->getPartition());
    }

    public function testAssignWithNullShouldClearAssignment()
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

    public function testSubscribe()
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
        $this->assertEquals(KAFKA_TEST_TOPIC, $topicPartitions[0]);
        $this->assertEquals(KAFKA_TEST_TOPIC_PARTITIONS, $topicPartitions[1]);
    }

    public function testUnsubscribe()
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
        $this->assertEquals(KAFKA_TEST_TOPIC, $topicPartitions[0]);
    }

    public function testConsume()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . rand(0, 999999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('auto.offset.reset', 'earliest');

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        // wait for partition assignment
        sleep(1);

        $lastMessage = $message = null;
        while (true) {
            $message = $consumer->consume((int)KAFKA_TEST_TIMEOUT_MS);
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
        $this->assertEquals('payload-kafka-consumer-2', $message->payload);

        $message = $consumer->consume(0);

        $this->assertInstanceOf(Message::class, $message);
        $this->assertEquals(RD_KAFKA_RESP_ERR__TIMED_OUT, $message->err);

        $consumer->unsubscribe();
    }

    public function testCommitWithInvalidArgumentShouldFail()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);

        $this->expectException(InvalidArgumentException::class);
        $this->expectDeprecationMessageMatches('/\bcommit\b/');
        $this->expectDeprecationMessageMatches('/object/');
        $consumer->commit(new stdClass());
    }

    public function testCommitAsyncWithInvalidArgumentShouldFail()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);

        $this->expectException(InvalidArgumentException::class);
        $this->expectDeprecationMessageMatches('/commitAsync\b/');
        $this->expectDeprecationMessageMatches('/bool/');
        $consumer->commitAsync(false);
    }

    public function testCommitWithMessage()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . rand(0, 999999999));
        $conf->set('enable.auto.commit', 'false');
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('auto.offset.reset', 'earliest');

        $offset = 0;

        $conf->setOffsetCommitCb(
            function (KafkaConsumer $kafka, int $err, array $topicPartitions, $opaque = null) use (&$offset) {
                $offset = $topicPartitions[0]->getOffset();
            }
        );

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        // wait for partition assignment
        sleep(1);

        $lastMessage = $message = null;
        while (true) {
            $message = $consumer->consume((int)KAFKA_TEST_TIMEOUT_MS);
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
        $consumer->consume((int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertEquals($message->offset + 1, $offset);

        $consumer->unsubscribe();
    }

    public function testCommitWithOffset()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . rand(0, 999999999));
        $conf->set('enable.auto.commit', 'false');
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('auto.offset.reset', 'earliest');

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        // wait for partition assignment
        sleep(1);

        $consumer->commit([new TopicPartition(KAFKA_TEST_TOPIC, 0, 1)]);

        $topicPartitions = $consumer->getCommittedOffsets(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ],
            (int)KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertEquals(1, $topicPartitions[0]->getOffset());

        $consumer->unsubscribe();
    }

    public function testCommitAsyncWithOffset()
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
            (int)KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertEquals(2, $topicPartitions[0]->getOffset());
    }

    public function testGetCommittedOffsets()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . rand(0, 999999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('auto.offset.reset', 'earliest');

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        $topicPartitions = $consumer->getCommittedOffsets(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ],
            (int)KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertEquals(-1001 /*RD_KAFKA_OFFSET_INVALID*/, $topicPartitions[0]->getOffset());

        $message = $consumer->consume((int)KAFKA_TEST_TIMEOUT_MS);
        $consumer->commit($message);
        $message = $consumer->consume((int)KAFKA_TEST_TIMEOUT_MS);
        $consumer->commit($message);

        $topicPartitions = $consumer->getCommittedOffsets(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ],
            (int)KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertEquals(2, $topicPartitions[0]->getOffset());
    }

    public function testOffsetsForTimesWithFutureTimestamp()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . rand(0, 999999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);

        $future = (int)(time() + 3600) * 1000;

        $consumer = new KafkaConsumer($conf);
        $topicPartitions = $consumer->offsetsForTimes(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0, $future),
            ],
            (int)KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertEquals(-1 /* no offsets in the future */, $topicPartitions[0]->getOffset());
    }

    public function testOffsetsForTimesWithNearNowTimestamp()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . rand(0, 999999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);

        $nearNow = (int)(time()) * 1000;

        // produce two messages
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(RD_KAFKA_PARTITION_UA, 0, 'offsetsForTimes1');
        $producerTopic->produce(RD_KAFKA_PARTITION_UA, 0, 'offsetsForTimes2');
        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $consumer = new KafkaConsumer($conf);
        $topicPartitions = $consumer->offsetsForTimes(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0, $nearNow),
            ],
            (int)KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertGreaterThan(1, $topicPartitions[0]->getOffset());
    }

    public function testOffsetsForTimesWithAncientTimestamp()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . rand(0, 999999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);

        $past = 0;

        $consumer = new KafkaConsumer($conf);
        $topicPartitions = $consumer->offsetsForTimes(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0, $past),
            ],
            (int)KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertEquals(0, $topicPartitions[0]->getOffset());
    }

    public function testGetMetadata()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $conf->set('metadata.broker.list', KAFKA_BROKERS);

        $consumer = new KafkaConsumer($conf);

        $metadata = $consumer->getMetadata(true, null, (int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertInstanceOf(Metadata::class, $metadata);
    }

    public function testNewTopic()
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
