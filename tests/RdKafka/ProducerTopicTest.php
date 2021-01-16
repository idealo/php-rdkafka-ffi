<?php

declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RdKafka;
use RequireVersionTrait;

/**
 * @covers \RdKafka\ProducerTopic
 * @covers \RdKafka\Topic
 */
class ProducerTopicTest extends TestCase
{
    use RequireVersionTrait;

    public function testGetName(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);

        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $topicName = $topic->getName();

        $this->assertSame(KAFKA_TEST_TOPIC, $topicName);
    }

    /**
     * @group ffiOnly
     */
    public function testGetCData(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);

        $cData = $producer->getCData();

        $this->assertInstanceOf(CData::class, $cData);
    }

    public function testProduce(): void
    {
        $payload = '';

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$payload): void {
                $payload = $message->payload;
            }
        );
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, __METHOD__, 'key-topic-produce');

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(__METHOD__, $payload);
    }

    public function testProduceWithTombstone(): void
    {
        $payload = '';

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$payload): void {
                $payload = $message->payload;
            }
        );
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, null, 'key-topic-produce');

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertNull($payload);
    }

    public function testProduceWithOpaque(): void
    {
        $this->requiresRdKafkaExtensionVersion('>=', '5');

        $opaques = [];
        $expectedOpaque1 = 'opaque1';
        $expectedOpaque2 = 'opaque2';
        $expectedOpaque3 = 'opaque3';

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$opaques): void {
                $opaques[] = $message->opaque;
            }
        );
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'payload-1', null, $expectedOpaque1);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'payload-2', null, $expectedOpaque2);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'payload-3', null, $expectedOpaque3);

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame($expectedOpaque1, $opaques[0]);
        $this->assertSame($expectedOpaque2, $opaques[1]);
        $this->assertSame($expectedOpaque3, $opaques[2]);
    }

    public function testProduceWithInvalidPartitionShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $topic->produce(-2, 0);
    }

    public function testProduceWithInvalidMsgFlagsShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/msgflags/');
        $topic->produce(0, -1);
    }

    public function testProducev(): void
    {
        $payload = '';

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$payload): void {
                $payload = $message->payload;
            }
        );
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $topic->producev(RD_KAFKA_PARTITION_UA, 0, __METHOD__, 'key-topic-produce');

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(__METHOD__, $payload);
    }

    public function testProducevWithTombstone(): void
    {
        $payload = '';

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$payload): void {
                $payload = $message->payload;
            }
        );
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $topic->producev(RD_KAFKA_PARTITION_UA, 0, null, 'key-topic-produce');

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertNull($payload);
    }

    public function testProducevWithHeader(): void
    {
        $payload = '';
        $headers = [];

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$payload, &$headers): void {
                $payload = $message->payload;
                $headers = $message->headers;
            }
        );
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $topic->producev(
            RD_KAFKA_PARTITION_UA,
            0,
            __METHOD__,
            'key-topic-produce',
            [
                'header-name-topic-produce' => 'header-value-topic-produce',
            ]
        );

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(__METHOD__, $payload);
        $this->assertSame(
            [
                'header-name-topic-produce' => 'header-value-topic-produce',
            ],
            $headers
        );
    }

    public function testProducevWithTimestamp(): void
    {
        $payload = '';
        $timestamp = -1;

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$payload, &$timestamp): void {
                $payload = $message->payload;
                $timestamp = $message->timestamp;
            }
        );
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $topic->producev(
            RD_KAFKA_PARTITION_UA,
            0,
            __METHOD__,
            'key-topic-produce',
            [],
            123456789
        );

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(__METHOD__, $payload);
        $this->assertSame(123456789, $timestamp);
    }

    public function testProducevWithOpaque(): void
    {
        $this->requiresRdKafkaExtensionVersion('>=', '5');

        $opaques = [];
        $expectedOpaque1 = 'opaque1';
        $expectedOpaque2 = 'opaque2';
        $expectedOpaque3 = 'opaque3';

        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$opaques): void {
                $opaques[] = $message->opaque;
            }
        );

        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $topic->producev(
            RD_KAFKA_PARTITION_UA,
            0,
            __METHOD__,
            'key-topic-produce',
            null,
            null,
            $expectedOpaque1
        );
        $topic->producev(
            RD_KAFKA_PARTITION_UA,
            0,
            __METHOD__,
            'key-topic-produce',
            null,
            null,
            $expectedOpaque2
        );
        $topic->producev(
            RD_KAFKA_PARTITION_UA,
            0,
            __METHOD__,
            'key-topic-produce',
            null,
            null,
            $expectedOpaque3
        );

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame($expectedOpaque1, $opaques[0]);
        $this->assertSame($expectedOpaque2, $opaques[1]);
        $this->assertSame($expectedOpaque3, $opaques[2]);
    }

    public function testProducevWithInvalidPartitionShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $topic->producev(-2, 0);
    }

    public function testProducevWithInvalidMsgFlagsShouldFail(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($conf);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/msgflags/');
        $topic->producev(0, -1);
    }
}
