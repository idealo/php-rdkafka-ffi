<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use RdKafka\Conf;
use RdKafka\KafkaConsumer;
use RdKafka\Producer;
use RdKafka\TopicPartition;

/**
 * @covers \RdKafka
 */
class RdKafkaTest extends TestCase
{
    use RequireVersionTrait;

    public function testPauseAndResumePartitionsWithProducer(): void
    {
        $this->requiresRdKafkaExtensionVersion('>=', '5.1');

        $producerConf = new Conf();
        $producerConf->set('bootstrap.servers', KAFKA_BROKERS);

        $producer = new Producer($producerConf);
        $producer->newTopic(KAFKA_TEST_TOPIC);

        $partitions = $producer->pausePartitions([new TopicPartition(KAFKA_TEST_TOPIC, 0)]);
        $this->assertCount(1, $partitions);
        $this->assertSame(KAFKA_TEST_TOPIC, $partitions[0]->getTopic());
        $this->assertSame(0, $partitions[0]->getPartition());
        $this->assertSame(0, $partitions[0]->getErr());

        $partitions = $producer->resumePartitions([new TopicPartition(KAFKA_TEST_TOPIC, 0)]);
        $this->assertCount(1, $partitions);
        $this->assertSame(KAFKA_TEST_TOPIC, $partitions[0]->getTopic());
        $this->assertSame(0, $partitions[0]->getPartition());
        $this->assertSame(0, $partitions[0]->getErr());

        $partitions = $producer->resumePartitions([new TopicPartition('unknown', -1)]);
        $this->assertCount(1, $partitions);
        $this->assertSame('unknown', $partitions[0]->getTopic());
        $this->assertSame(-1, $partitions[0]->getPartition());
        $this->assertSame(-190, $partitions[0]->getErr());
    }

    public function testPauseAndResumePartitionsWithKafkaConsumer(): void
    {
        $this->requiresRdKafkaExtensionVersion('>=', '5.1');

        $conf = new Conf();
        $conf->set('group.id', __METHOD__ . random_int(0, 999999999));
        $conf->set('bootstrap.servers', KAFKA_BROKERS);

        $consumer = new KafkaConsumer($conf);
        $consumer->assign([new TopicPartition(KAFKA_TEST_TOPIC, 0)]);

        $partitions = $consumer->pausePartitions([new TopicPartition(KAFKA_TEST_TOPIC, 0)]);
        $this->assertCount(1, $partitions);
        $this->assertSame(KAFKA_TEST_TOPIC, $partitions[0]->getTopic());
        $this->assertSame(0, $partitions[0]->getPartition());
        $this->assertSame(0, $partitions[0]->getErr());

        $partitions = $consumer->resumePartitions([new TopicPartition(KAFKA_TEST_TOPIC, 0)]);
        $this->assertCount(1, $partitions);
        $this->assertSame(KAFKA_TEST_TOPIC, $partitions[0]->getTopic());
        $this->assertSame(0, $partitions[0]->getPartition());
        $this->assertSame(0, $partitions[0]->getErr());

        $partitions = $consumer->resumePartitions([new TopicPartition('unknown', -1)]);
        $this->assertCount(1, $partitions);
        $this->assertSame('unknown', $partitions[0]->getTopic());
        $this->assertSame(-1, $partitions[0]->getPartition());
        $this->assertSame(-190, $partitions[0]->getErr());
    }
}
