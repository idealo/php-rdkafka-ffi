<?php
declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\ProducerTopic
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
        $conf->setDrMsgCb(function (\RdKafka $kafka, Message $message) use (&$payload) {
            $payload = $message->payload;
        });
        $producer = new Producer($conf);
        $producer->addBrokers(KAFKA_BROKERS);
        $topic = $producer->newTopic(KAFKA_TEST_TOPIC);

        $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'payload-topic-produce', 'key-topic-produce');

        $producer->poll(1000);

        $this->assertEquals('payload-topic-produce', $payload);
    }
}
