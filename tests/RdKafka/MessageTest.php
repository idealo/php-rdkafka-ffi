<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Message
 */
class MessageTest extends TestCase
{
    private Message $message;
    private Message $producedMessage;
    private float $expectedLatencyInSeconds;
    private int $beforeProducingTimestamp;

    protected function prepareMessage(...$params)
    {
        $this->beforeProducingTimestamp = time();

        $context = $this;
        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->setDrMsgCb(
            function ($producer, $message) use ($context) {
                $context->producedMessage = $message;
                $context->expectedLatencyInSeconds = microtime(true) - $context->expectedLatencyInSeconds;
            }
        );
        $producer = new Producer($conf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $this->expectedLatencyInSeconds = microtime(true);
        $producerTopic->producev(...$params);
        $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeStart(0, rd_kafka_offset_tail(1));

        $this->message = $consumerTopic->consume(0, (int)KAFKA_TEST_TIMEOUT_MS);

        $consumerTopic->consumeStop(0);
    }

    public function testProperties()
    {
        $this->prepareMessage(0, 0, __METHOD__ . '1', 'key-msg', ['header-name' => 'header-value']);

        $this->assertEquals(RD_KAFKA_RESP_ERR_NO_ERROR, $this->message->err);
        $this->assertEquals(KAFKA_TEST_TOPIC, $this->message->topic_name);
        $this->assertEquals(0, $this->message->partition);
        $this->assertEquals(__METHOD__ . '1', $this->message->payload);
        $this->assertEquals('key-msg', $this->message->key);
        $this->assertEquals(['header-name' => 'header-value'], $this->message->headers);
        $this->assertGreaterThan(0, $this->message->offset);

        $this->prepareMessage(0, 0, __METHOD__ . '2');

        $this->assertEquals(__METHOD__ . '2', $this->message->payload);
        $this->assertEquals(null, $this->message->key);
        $this->assertEquals(null, $this->message->headers);
    }

    /**
     * @group ffiOnly
     */
    public function testPropertyTimestamp()
    {
        $this->prepareMessage(0, 0, __METHOD__);

        $this->assertEquals(__METHOD__, $this->message->payload);
        $this->assertGreaterThan($this->beforeProducingTimestamp, $this->message->timestamp);
        $this->assertEquals(1 /*RD_KAFKA_TIMESTAMP_CREATE_TIME*/, $this->message->timestampType);
    }

    /**
     * @group ffiOnly
     */
    public function testPropertyStatus()
    {
        $this->prepareMessage(0, 0, __METHOD__);

        $this->assertEquals(__METHOD__, $this->message->payload);
        $this->assertEquals(RD_KAFKA_MSG_STATUS_PERSISTED, $this->message->status);
    }

    /**
     * @group ffiOnly
     */
    public function testPropertyLatency()
    {
        $this->prepareMessage(0, 0, __METHOD__);

        $expectedLatencyInMicroseconds = $this->expectedLatencyInSeconds * 1000 * 1000;

        $this->assertEquals(__METHOD__, $this->message->payload);
        $this->assertGreaterThan($expectedLatencyInMicroseconds - 500, $this->producedMessage->latency);
        $this->assertLessThan($expectedLatencyInMicroseconds + 500, $this->producedMessage->latency);
    }

    public function testErrstr()
    {
        $this->prepareMessage(0, 0, __METHOD__);

        $this->assertEquals(__METHOD__, $this->message->payload);
        $this->assertEquals('Success', $this->message->errstr());
    }
}
