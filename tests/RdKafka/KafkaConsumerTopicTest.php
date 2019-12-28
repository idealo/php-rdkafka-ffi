<?php

declare(strict_types=1);

namespace RdKafka;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\KafkaConsumerTopic
 * @covers \RdKafka\Topic
 */
class KafkaConsumerTopicTest extends TestCase
{
    public function testGetName()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);
        $conf->set('metadata.broker.list', KAFKA_BROKERS);

        $consumer = new KafkaConsumer($conf);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC, new TopicConf());

        $name = $topic->getName();

        $this->assertEquals(KAFKA_TEST_TOPIC, $name);
    }

    public function testOffsetStore()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . rand(0, 99999999));
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->set('enable.auto.offset.store', 'false');
        $consumer = new KafkaConsumer($conf);
        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC, 0)]);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $topicPartitions = $consumer->getCommittedOffsets(
            [new TopicPartition(KAFKA_TEST_TOPIC, 0)],
            (int)KAFKA_TEST_TIMEOUT_MS
        );
        $this->assertEquals(-1001, $topicPartitions[0]->getOffset());

        $topic->offsetStore(0, 1);
        $consumer->commit();

        $topicPartitions = $consumer->getCommittedOffsets(
            [new TopicPartition(KAFKA_TEST_TOPIC, 0)],
            (int)KAFKA_TEST_TIMEOUT_MS
        );
        $this->assertEquals(2, $topicPartitions[0]->getOffset());
    }

    public function testOffsetStoreWithInvalidPartitionShouldFail()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . rand(0, 99999999));
        $consumer = new KafkaConsumer($conf);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $topic->offsetStore(-111, 0);
    }
}
