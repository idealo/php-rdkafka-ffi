<?php
declare(strict_types=1);

namespace RdKafka;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RdKafka;
use stdClass;

/**
 * @covers \RdKafka\KafkaConsumer
 * @covers \RdKafka\Conf
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
        $producer->poll((int)KAFKA_TEST_TIMEOUT_MS);
    }

    public function testConstructWithMissingGroupIdConfShouldFail()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessageRegExp('/group\.id/');

        new KafkaConsumer(new Conf());
    }

    public function testAssign()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->assign([
            new TopicPartition(KAFKA_TEST_TOPIC, 0),
            new TopicPartition('test_KafkaConsumer', 2),
        ]);

        $topicPartitions = $consumer->getAssignment();

        $this->assertCount(2, $topicPartitions);
        $this->assertEquals(KAFKA_TEST_TOPIC, $topicPartitions[0]->getTopic());
        $this->assertEquals(0, $topicPartitions[0]->getPartition());
        $this->assertEquals('test_KafkaConsumer', $topicPartitions[1]->getTopic());
        $this->assertEquals(2, $topicPartitions[1]->getPartition());
    }

    public function testAssignWithNullShouldClearAssignment()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->assign([
            new TopicPartition(KAFKA_TEST_TOPIC, 0),
        ]);

        $this->assertCount(1, $consumer->getAssignment());

        $consumer->assign();

        $this->assertCount(0, $consumer->getAssignment());
    }

    public function testSubscribe()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([
            KAFKA_TEST_TOPIC,
            'test_KafkaConsumer',
        ]);

        $topicPartitions = $consumer->getSubscription();

        $this->assertCount(2, $topicPartitions);
        $this->assertEquals(KAFKA_TEST_TOPIC, $topicPartitions[0]);
        $this->assertEquals('test_KafkaConsumer', $topicPartitions[1]);
    }

    public function testUnsubscribe()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([
            KAFKA_TEST_TOPIC,
        ]);

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
        $topicConf = new TopicConf();
        $topicConf->set('auto.offset.reset', 'smallest');
        $conf->setDefaultTopicConf($topicConf);

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        $lastMessage = null;
        while (true) {
            $message = $consumer->consume((int)KAFKA_TEST_TIMEOUT_MS);
            if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
                $message = $lastMessage;
                break;
            }
            $lastMessage = $message;
        }

        $this->assertEquals('payload-kafka-consumer-2', $message->payload);
    }

    public function testCommitWithInvalidArgumentShouldFail()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/\bcommit\b/');
        $this->expectExceptionMessageRegExp('/stdClass/');
        $consumer->commit(new stdClass());
    }

    public function testCommitAsyncWithInvalidArgumentShouldFail()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/commitAsync\b/');
        $this->expectExceptionMessageRegExp('/bool/');
        $consumer->commitAsync(false);
    }

    public function testCommitWithMessage()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $topicConf = new TopicConf();
        $topicConf->set('auto.offset.reset', 'smallest');

        $conf->setDefaultTopicConf($topicConf);

        $offset = 0;

        $conf->setOffsetCommitCb(function (RdKafka $kafka, int $err, array $topicPartitions, $opaque = null) use (&$offset) {
            $offset = $topicPartitions[0]->getOffset();
        });

        $consumer = new KafkaConsumer($conf);
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        $message = $consumer->consume((int)KAFKA_TEST_TIMEOUT_MS);
        $consumer->commit($message);

        // consume to trigger callback
        $consumer->consume((int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertEquals($message->offset + 1, $offset);
    }

    public function testCommitWithOffset()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);
        $consumer->commit([new TopicPartition(KAFKA_TEST_TOPIC, 0, 1)]);

        $topicPartitions = $consumer->getCommittedOffsets(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ],
            (int)KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertEquals(1, $topicPartitions[0]->getOffset());
    }

    public function testCommitAsyncWithOffset()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumer->commitAsync([new TopicPartition(KAFKA_TEST_TOPIC, 0, 2)]);

        sleep((int)KAFKA_TEST_TIMEOUT_MS / 1000);

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
        $topicConf = new TopicConf();
        $topicConf->set('auto.offset.reset', 'smallest');
        $conf->setDefaultTopicConf($topicConf);

        $consumer = new KafkaConsumer($conf);
        $consumer->subscribe([KAFKA_TEST_TOPIC]);

        $topicPartitions = $consumer->getCommittedOffsets(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ],
            (int)KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertCount(1, $topicPartitions);
        $this->assertEquals(RD_KAFKA_OFFSET_INVALID, $topicPartitions[0]->getOffset());

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

    public function testGetMetadata()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->addBrokers(KAFKA_BROKERS);

        $metadata = $consumer->getMetadata(true, null, (int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertInstanceOf(Metadata::class, $metadata);
    }

    public function testNewTopic()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->assertInstanceOf(KafkaConsumerTopic::class, $topic);
    }
}
