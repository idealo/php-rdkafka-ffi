<?php
declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use PHPUnit\Framework\TestCase;
use RdKafka;

/**
 * @covers \RdKafka\ProducerTopic
 * @covers \RdKafka\Topic
 */
class ProducerTopicTest extends TestCase
{
    public function testGetName()
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);

        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $topicName = $topic->getName();

        $this->assertEquals(KAFKA_TEST_TOPIC, $topicName);
    }

    /**
     * @group ffiOnly
     */
    public function testGetCData()
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);

        $cData = $producer->getCData();

        $this->assertInstanceOf(CData::class, $cData);
    }

    public function testProduce()
    {
        $payload = '';

        $conf = new Conf();
        $conf->setDrMsgCb(function (RdKafka $kafka, Message $message) use (&$payload) {
            $payload = $message->payload;
        });
        $producer = new Producer($conf);
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, __METHOD__, 'key-topic-produce');

        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertEquals(__METHOD__, $payload);
    }

    public function testProduceWithInvalidPartitionShouldFail()
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/partition/');
        $topic->produce(-2, 0);
    }

    public function testProduceWithInvalidMsgFlagsShouldFail()
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/msgflags/');
        $topic->produce(0, -1);
    }

    public function testProducevWithTombstone()
    {
        $payload = '';

        $conf = new Conf();
        $conf->setDrMsgCb(function (RdKafka $kafka, Message $message) use (&$payload) {
            $payload = $message->payload;
        });
        $producer = new Producer($conf);
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $topic->producev(RD_KAFKA_PARTITION_UA, 0, null, 'key-topic-produce');

        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertEquals(null, $payload);
    }

    public function testProducevWithHeader()
    {
        $payload = '';
        $headers = [];

        $conf = new Conf();
        $conf->setDrMsgCb(function (RdKafka $kafka, Message $message) use (&$payload, &$headers) {
            $payload = $message->payload;
            $headers = $message->headers;
        });
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

        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertEquals(__METHOD__, $payload);
        $this->assertEquals(['header-name-topic-produce' => 'header-value-topic-produce'], $headers);
    }

    public function testProducevWithTimestamp()
    {
        $payload = '';
        $timestamp = -1;

        $conf = new Conf();
        $conf->setDrMsgCb(function (RdKafka $kafka, Message $message) use (&$payload, &$timestamp) {
            $payload = $message->payload;
            $timestamp = $message->timestamp;
        });
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

        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertEquals(__METHOD__, $payload);
        $this->assertEquals(123456789, $timestamp);
    }

    public function testProducevWithInvalidPartitionShouldFail()
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/partition/');
        $topic->producev(-2, 0);
    }

    public function testProducevWithInvalidMsgFlagsShouldFail()
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageRegExp('/msgflags/');
        $topic->producev(0, -1);
    }
}
