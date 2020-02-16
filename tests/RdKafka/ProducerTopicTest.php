<?php

declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RdKafka;

/**
 * @covers \RdKafka\ProducerTopic
 * @covers \RdKafka\Topic
 */
class ProducerTopicTest extends TestCase
{
    public function testGetName(): void
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);

        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $topicName = $topic->getName();

        $this->assertSame(KAFKA_TEST_TOPIC, $topicName);
    }

    /**
     * @group ffiOnly
     */
    public function testGetCData(): void
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);

        $cData = $producer->getCData();

        $this->assertInstanceOf(CData::class, $cData);
    }

    public function testProduce(): void
    {
        $payload = '';

        $conf = new Conf();
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$payload): void {
                $payload = $message->payload;
            }
        );
        $producer = new Producer($conf);
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, __METHOD__, 'key-topic-produce');

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(__METHOD__, $payload);
    }

    public function testProduceWithInvalidPartitionShouldFail(): void
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $topic->produce(-2, 0);
    }

    public function testProduceWithInvalidMsgFlagsShouldFail(): void
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/msgflags/');
        $topic->produce(0, -1);
    }

    public function testProducevWithTombstone(): void
    {
        $payload = '';

        $conf = new Conf();
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$payload): void {
                $payload = $message->payload;
            }
        );
        $producer = new Producer($conf);
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $topic->producev(RD_KAFKA_PARTITION_UA, 0, null, 'key-topic-produce');

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(null, $payload);
    }

    public function testProducevWithHeader(): void
    {
        $payload = '';
        $headers = [];

        $conf = new Conf();
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$payload, &$headers): void {
                $payload = $message->payload;
                $headers = $message->headers;
            }
        );
        $producer = new Producer($conf);
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $topic->producev(
            RD_KAFKA_PARTITION_UA,
            0,
            __METHOD__,
            'key-topic-produce',
            ['header-name-topic-produce' => 'header-value-topic-produce']
        );

        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(__METHOD__, $payload);
        $this->assertSame(['header-name-topic-produce' => 'header-value-topic-produce'], $headers);
    }

    public function testProducevWithTimestamp(): void
    {
        $payload = '';
        $timestamp = -1;

        $conf = new Conf();
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message) use (&$payload, &$timestamp): void {
                $payload = $message->payload;
                $timestamp = $message->timestamp;
            }
        );
        $producer = new Producer($conf);
        $producer->addBrokers(KAFKA_BROKERS);
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

    public function testProducevWithInvalidPartitionShouldFail(): void
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/partition/');
        $topic->producev(-2, 0);
    }

    public function testProducevWithInvalidMsgFlagsShouldFail(): void
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/msgflags/');
        $topic->producev(0, -1);
    }
}
