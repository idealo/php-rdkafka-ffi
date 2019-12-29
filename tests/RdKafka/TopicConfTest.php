<?php

declare(strict_types=1);

namespace RdKafka;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\TopicConf
 * @covers \RdKafka\Exception
 */
class TopicConfTest extends TestCase
{
    public function testDump()
    {
        $conf = new TopicConf();

        $expectedKeys = [
            'request.required.acks',
            'request.timeout.ms',
            'message.timeout.ms',
            'queuing.strategy',
            'produce.offset.report',
            'partitioner',
            'compression.codec',
            'compression.level',
            'auto.commit.enable',
            'auto.commit.interval.ms',
            'auto.offset.reset',
            'offset.store.path',
            'offset.store.sync.interval.ms',
            'offset.store.method',
            'consume.callback.max.messages',
        ];

        $keys = \array_keys($conf->dump());

        $this->assertEquals($expectedKeys, $keys);
    }

    function testSet()
    {
        $conf = new TopicConf();
        $conf->set('partitioner', 'consistent');

        $dump = $conf->dump();

        $this->assertEquals('consistent', $dump['partitioner']);
    }

    public function testSetWithUnknownPropertyShouldFail()
    {
        $conf = new TopicConf();

        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/configuration property.+any.unknown/');
        $conf->set('any.unknown', 'property');
    }

    function testSetWithInvalidValueShouldFail()
    {
        $conf = new TopicConf();

        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/Invalid value.+partitioner/');
        $conf->set('partitioner', 'any.unknown');
    }

    public function testSetPartitioner()
    {
        $conf = new TopicConf();
        $conf->setPartitioner(RD_KAFKA_MSG_PARTITIONER_CONSISTENT);

        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC_PARTITIONS, $conf);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test1', '1'); // crc32 % 3 = 2
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test2', '2'); // crc32 % 3 = 1
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test3', '3'); // crc32 % 3 = 1
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test4', '1'); // crc32 % 3 = 2
        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC_PARTITIONS, $conf);

        $consumerTopic->consumeStart(1, rd_kafka_offset_tail(2));
        $msg2 = $consumerTopic->consume(1, (int)KAFKA_TEST_TIMEOUT_MS);
        $msg3 = $consumerTopic->consume(1, (int)KAFKA_TEST_TIMEOUT_MS);
        $consumerTopic->consumeStop(1);

        $consumerTopic->consumeStart(2, rd_kafka_offset_tail(2));
        $msg1 = $consumerTopic->consume(2, (int)KAFKA_TEST_TIMEOUT_MS);
        $msg4 = $consumerTopic->consume(2, (int)KAFKA_TEST_TIMEOUT_MS);
        $consumerTopic->consumeStop(2);

        $this->assertEquals('test1', $msg1->payload);
        $this->assertEquals('test2', $msg2->payload);
        $this->assertEquals('test3', $msg3->payload);
        $this->assertEquals('test4', $msg4->payload);
    }

    public function testSetPartitionerWithUnknownId()
    {
        $conf = new TopicConf();

        $this->expectException(InvalidArgumentException::class);
        $conf->setPartitioner(9999);
    }

    /**
     * @group ffiOnly
     */
    public function testSetPartitionerCb()
    {
        $conf = new TopicConf();
        $conf->setPartitionerCb(
            function ($key, $partitionCount) {
                return 2; // force partition 2
            }
        );

        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC_PARTITIONS, $conf);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test1', '1');
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test2', '2');
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test3', '3');
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test4', '1');
        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC_PARTITIONS, $conf);

        $consumerTopic->consumeStart(2, rd_kafka_offset_tail(4));
        $msg1 = $consumerTopic->consume(2, (int)KAFKA_TEST_TIMEOUT_MS);
        $msg2 = $consumerTopic->consume(2, (int)KAFKA_TEST_TIMEOUT_MS);
        $msg3 = $consumerTopic->consume(2, (int)KAFKA_TEST_TIMEOUT_MS);
        $msg4 = $consumerTopic->consume(2, (int)KAFKA_TEST_TIMEOUT_MS);
        $consumerTopic->consumeStop(2);

        $this->assertEquals('test1', $msg1->payload);
        $this->assertEquals('test2', $msg2->payload);
        $this->assertEquals('test3', $msg3->payload);
        $this->assertEquals('test4', $msg4->payload);
    }
}
