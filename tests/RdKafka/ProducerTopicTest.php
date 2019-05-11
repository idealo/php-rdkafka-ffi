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

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'payload-topic-produce', 'key-topic-produce');

        $producer->poll((int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertEquals('payload-topic-produce', $payload);
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

        $producer->poll((int)KAFKA_TEST_TIMEOUT_MS);

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
            'payload-topic-produce',
            'key-topic-produce',
            ['header-name-topic-produce' => 'header-value-topic-produce']
        );

        $producer->poll((int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertEquals('payload-topic-produce', $payload);
        $this->assertEquals(['header-name-topic-produce' => 'header-value-topic-produce'], $headers);
    }
}
