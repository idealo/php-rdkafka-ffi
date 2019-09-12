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
    public function testFromCData()
    {
        $conf = new Conf();
        $conf->set('group.id', __METHOD__);

        $consumer = new KafkaConsumer($conf);
        $consumer->assign([
            new TopicPartition(KAFKA_TEST_TOPIC, 0),
        ]);

        $topicPartitions = $consumer->getAssignment();

        $this->assertCount(1, $topicPartitions);
        $this->assertEquals(KAFKA_TEST_TOPIC, $topicPartitions[0]->getTopic());
        $this->assertEquals(0, $topicPartitions[0]->getPartition());
        $this->assertEquals(0, $topicPartitions[0]->getErr());
        $this->assertEquals('', $topicPartitions[0]->getMetadata());
        $this->assertEquals(0, $topicPartitions[0]->getOffset());
    }

    public function testGetterAndSetter()
    {
        $topicPartition = new TopicPartition(KAFKA_TEST_TOPIC, 0);

        $this->assertEquals(KAFKA_TEST_TOPIC, $topicPartition->getTopic());
        $this->assertEquals(0, $topicPartition->getPartition());
        $this->assertEquals(null, $topicPartition->getOffset());
        $this->assertEquals(null, $topicPartition->getErr());
        $this->assertEquals(null, $topicPartition->getOpqaque());
        $this->assertEquals(null, $topicPartition->getMetadata());

        $topicPartition->setTopic('other');
        $topicPartition->setPartition(1);
        $topicPartition->setOffset(2);

        $this->assertEquals('other', $topicPartition->getTopic());
        $this->assertEquals(1, $topicPartition->getPartition());
        $this->assertEquals(2, $topicPartition->getOffset());
    }
}
