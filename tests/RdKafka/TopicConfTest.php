<?php

declare(strict_types=1);

namespace RdKafka;

use ConsumeTrait;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RequireVersionTrait;

/**
 * @covers \RdKafka\TopicConf
 * @covers \RdKafka\Exception
 * @covers \RdKafka\FFI\NativePartitionerCallbackProxy
 * @covers \RdKafka\FFI\PartitionerCallbackProxy
 */
class TopicConfTest extends TestCase
{
    use RequireVersionTrait;
    use ConsumeTrait;

    public function testDump(): void
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

        $this->assertSame($expectedKeys, $keys);
    }

    public function testSet(): void
    {
        $conf = new TopicConf();
        $conf->set('partitioner', 'consistent');

        $dump = $conf->dump();

        $this->assertSame('consistent', $dump['partitioner']);
    }

    public function testSetWithUnknownPropertyShouldFail(): void
    {
        $conf = new TopicConf();

        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/configuration property.+any.unknown/');
        $conf->set('any.unknown', 'property');
    }

    public function testSetWithInvalidValueShouldFail(): void
    {
        $conf = new TopicConf();

        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/Invalid value.+partitioner/');
        $conf->set('partitioner', 'any.unknown');
    }

    public function testSetPartitioner(): void
    {
        $topicConf = new TopicConf();
        $topicConf->setPartitioner(RD_KAFKA_MSG_PARTITIONER_CONSISTENT);

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC_PARTITIONS, $topicConf);

        // crc32 % 3 = 2
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test1', '1');
        // crc32 % 3 = 1
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test2', '2');
        // crc32 % 3 = 1
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test3', '3');
        // crc32 % 3 = 2
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test4', '1');
        $producer->flush(KAFKA_TEST_LONG_TIMEOUT_MS);

        $consumer = new Consumer($conf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC_PARTITIONS);

        $consumerTopic->consumeStart(1, rd_kafka_offset_tail(2));
        $messages = $this->consumeMessagesWithConsumerTopic($consumerTopic, 1, 2);
        $consumerTopic->consumeStop(1);

        $this->assertSame('test2', $messages[0]->payload);
        $this->assertSame('test3', $messages[1]->payload);

        $consumerTopic->consumeStart(2, rd_kafka_offset_tail(2));
        $messages = $this->consumeMessagesWithConsumerTopic($consumerTopic, 2, 2);
        $consumerTopic->consumeStop(2);

        $this->assertSame('test1', $messages[0]->payload);
        $this->assertSame('test4', $messages[1]->payload);
    }

    public function testSetPartitionerWithUnknownId(): void
    {
        $conf = new TopicConf();

        $this->expectException(InvalidArgumentException::class);
        $conf->setPartitioner(9999);
    }

    public function testSetPartitionerWithUnsupportedTypeShouldFail(): void
    {
        $this->requiresLibrdkafkaVersion('<', '1.4.0');

        $conf = new TopicConf();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('/rd_kafka_msg_partitioner_fnv1a_random/');
        $conf->setPartitioner(RD_KAFKA_MSG_PARTITIONER_FNV1A);
    }

    /**
     * @group ffiOnly
     */
    public function testSetPartitionerCb(): void
    {
        $topicConf = new TopicConf();
        $topicConf->setPartitionerCb(
            function ($key, $partitionCount) {
                // force partition 2
                return 2;
            }
        );

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC_PARTITIONS, $topicConf);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test1', '1');
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test2', '2');
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test3', '3');
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test4', '1');
        $producer->flush(KAFKA_TEST_LONG_TIMEOUT_MS);

        $consumer = new Consumer($conf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC_PARTITIONS);

        $consumerTopic->consumeStart(2, rd_kafka_offset_tail(4));
        $messages = $this->consumeMessagesWithConsumerTopic($consumerTopic, 2, 4);
        $consumerTopic->consumeStop(2);

        $this->assertSame('test1', $messages[0]->payload);
        $this->assertSame('test2', $messages[1]->payload);
        $this->assertSame('test3', $messages[2]->payload);
        $this->assertSame('test4', $messages[3]->payload);
    }

    /**
     * @group ffiOnly
     */
    public function testSetPartitionerCbWithCallback(): void
    {
        $expectedTopicOpaque = new \stdClass();
        $expectedMessageOpaque = new \stdClass();

        $callbackTopicOpaque = null;
        $callbackMessageOpaque = null;

        $topicConf = new TopicConf();
        $topicConf->setOpaque($expectedTopicOpaque);
        $topicConf->setPartitionerCb(
            function (?string $key, int $partitionCount, ?object $topic_opaque = null, ?object $message_opaque = null) use (
                &
                $callbackTopicOpaque,
                &$callbackMessageOpaque
            ) {
                $callbackTopicOpaque = $topic_opaque;
                $callbackMessageOpaque = $message_opaque;
                // force partition 2
                return 2;
            }
        );

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC_PARTITIONS, $topicConf);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test1', '1', $expectedMessageOpaque);
        $producer->flush(KAFKA_TEST_LONG_TIMEOUT_MS);

        $consumer = new Consumer($conf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC_PARTITIONS);

        $consumerTopic->consumeStart(2, rd_kafka_offset_tail(1));
        $messages = $this->consumeMessagesWithConsumerTopic($consumerTopic, 2, 1);
        $consumerTopic->consumeStop(2);

        $this->assertSame('test1', $messages[0]->payload);
        $this->assertSame($expectedTopicOpaque, $callbackTopicOpaque);
        $this->assertSame($expectedMessageOpaque, $callbackMessageOpaque);
    }
}
