<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;
use RdKafka\Metadata\Broker;
use RdKafka\Metadata\Collection;
use RdKafka\Metadata\Partition;
use RdKafka\Metadata\Topic;

/**
 * @covers \RdKafka\Metadata
 * @covers \RdKafka\Metadata\Broker
 * @covers \RdKafka\Metadata\Partition
 * @covers \RdKafka\Metadata\Topic
 */
class MetadataTest extends TestCase
{
    private Metadata $metadata;

    protected function setUp(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->set('topic.metadata.refresh.interval.ms', (string) 900);
        $producer = new Producer($conf);

        // wait for metadata refresh
        sleep(1);

        $this->metadata = $producer->getMetadata(true, null, KAFKA_TEST_TIMEOUT_MS);
    }

    public function testGetBrokers(): void
    {
        $brokers = $this->metadata->getBrokers();

        $this->assertInstanceOf(Collection::class, $brokers);
        $this->assertCount(1, $brokers);

        /** @var Broker $broker */
        $broker = $brokers->current();

        [$host, $port] = explode(':', KAFKA_BROKERS);
        $this->assertGreaterThan(0, $broker->getId());
        $this->assertSame($host, $broker->getHost());
        $this->assertSame((int) $port, $broker->getPort());
    }

    public function testGetTopics(): void
    {
        $topics = $this->metadata->getTopics();

        $this->assertInstanceOf(Collection::class, $topics);
        $this->assertGreaterThan(0, $topics->count());

        /** @var Topic $topic */
        $topic = $topics->current();

        $this->assertIsString($topic->getTopic());
        $this->assertSame(RD_KAFKA_RESP_ERR_NO_ERROR, $topic->getErr());

        $partitions = $topic->getPartitions();
        $this->assertInstanceOf(Collection::class, $partitions);

        /** @var Partition $partition */
        $partition = $partitions->current();

        $this->assertSame(0, $partition->getId());
        $this->assertSame(KAFKA_BROKER_ID, $partition->getIsrs()->current());
        $this->assertSame(KAFKA_BROKER_ID, $partition->getLeader());
        $this->assertSame(KAFKA_BROKER_ID, $partition->getReplicas()->current());
    }

    public function testGetOrigBrokerId(): void
    {
        $this->assertSame(KAFKA_BROKER_ID, $this->metadata->getOrigBrokerId());
    }

    public function testGetOrigBrokerName(): void
    {
        $this->assertSame(KAFKA_BROKERS . '/' . KAFKA_BROKER_ID, $this->metadata->getOrigBrokerName());
    }
}
