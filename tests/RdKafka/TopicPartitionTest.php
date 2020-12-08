<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\TopicPartition
 * @covers \RdKafka\TopicPartitionList
 */
class TopicPartitionTest extends TestCase
{
    public function testFromCData(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->assign(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ]
        );

        $topicPartitions = $consumer->getAssignment();

        $this->assertCount(1, $topicPartitions);
        $this->assertSame(KAFKA_TEST_TOPIC, $topicPartitions[0]->getTopic());
        $this->assertSame(0, $topicPartitions[0]->getPartition());
        $this->assertSame(0, $topicPartitions[0]->getOffset());
    }

    /**
     * @group ffiOnly
     */
    public function testFromCDataWithExtraGetters(): void
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->assign(
            [
                new TopicPartition(KAFKA_TEST_TOPIC, 0),
            ]
        );

        $topicPartitions = $consumer->getAssignment();

        $this->assertCount(1, $topicPartitions);
        $this->assertSame(KAFKA_TEST_TOPIC, $topicPartitions[0]->getTopic());
        $this->assertSame(0, $topicPartitions[0]->getErr());
        $this->assertNull($topicPartitions[0]->getOpqaque());
        $this->assertNull($topicPartitions[0]->getMetadata());
    }

    public function testGetterAndSetter(): void
    {
        $topicPartition = new TopicPartition(KAFKA_TEST_TOPIC, 0);

        $this->assertSame(KAFKA_TEST_TOPIC, $topicPartition->getTopic());
        $this->assertSame(0, $topicPartition->getPartition());
        $this->assertSame(0, $topicPartition->getOffset());

        $topicPartition->setTopic('other');
        $topicPartition->setPartition(1);
        $topicPartition->setOffset(2);

        $this->assertSame('other', $topicPartition->getTopic());
        $this->assertSame(1, $topicPartition->getPartition());
        $this->assertSame(2, $topicPartition->getOffset());
    }

    /**
     * @group ffiOnly
     */
    public function testGetAndSetMetaData(): void
    {
        $topicPartition = new TopicPartition(KAFKA_TEST_TOPIC, 0);

        $this->assertNull($topicPartition->getMetadata());
        $this->assertSame(0, $topicPartition->getMetadataSize());

        $topicPartition->setMetadata('meta');

        $this->assertSame('meta', $topicPartition->getMetadata());
        $this->assertSame(4, $topicPartition->getMetadataSize());
    }
}
