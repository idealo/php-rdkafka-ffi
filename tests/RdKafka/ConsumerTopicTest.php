<?php
declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\ConsumerTopic
 * @covers \RdKafka\Topic
 */
class ConsumerTopicTest extends TestCase
{
    /**
     * @group ffiOnly
     */
    public function testGetCData()
    {
        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $cData = $topic->getCData();

        $this->assertInstanceOf(CData::class, $cData);
    }

    public function testGetName()
    {
        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);

        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $name = $topic->getName();

        $this->assertEquals(KAFKA_TEST_TOPIC, $name);
    }

    public function testConsume()
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);

        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeStart(0, rd_kafka_offset_tail(1));

        $message = $consumerTopic->consume(0, (int)KAFKA_TEST_TIMEOUT_MS);

        $consumerTopic->consumeStop(0);

        $this->assertEquals(__METHOD__, $message->payload);
    }
}
