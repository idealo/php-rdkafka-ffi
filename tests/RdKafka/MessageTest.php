<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Message
 */
class MessageTest extends TestCase
{
    private $message;
    private $producedMessage;
    private $beforeProducingTimestamp;

    protected function setUp(): void
    {
        $this->beforeProducingTimestamp = time();

        $context = $this;
        $conf = new Conf();
        $conf->set('metadata.broker.list', KAFKA_BROKERS);
        $conf->setDrMsgCb(
            function ($producer, $message) use ($context) {
                $context->producedMessage = $message;
            }
        );
        $producer = new Producer($conf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->producev(0, 0, __CLASS__, 'key-msg', ['header-name' => 'header-value']);
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
        $this->assertEquals(0, $this->message->err);
        $this->assertEquals(KAFKA_TEST_TOPIC, $this->message->topic_name);
        $this->assertEquals(0, $this->message->partition);
        $this->assertEquals(__CLASS__, $this->message->payload);
        $this->assertEquals('key-msg', $this->message->key);
        $this->assertEquals(['header-name' => 'header-value'], $this->message->headers);

        $this->assertEquals(RD_KAFKA_RESP_ERR_NO_ERROR, $this->message->err);

        $this->assertGreaterThan($this->beforeProducingTimestamp, $this->message->timestamp);

        $this->assertGreaterThan(0, $this->message->offset);
    }

    /**
     * @group ffiOnly
     */
    public function testPropertyTimestampType()
    {
        $this->assertEquals(1 /*RD_KAFKA_TIMESTAMP_CREATE_TIME*/, $this->message->timestampType);
    }

    /**
     * @group ffiOnly
     */
    public function testPropertyStatus()
    {
        $this->assertEquals(RD_KAFKA_MSG_STATUS_PERSISTED, $this->message->status);
    }

    /**
     * @group ffiOnly
     */
    public function testPropertyLatency()
    {
        $this->assertGreaterThan((int)KAFKA_TEST_TIMEOUT_MS / 2, $this->producedMessage->latency);
    }

    public function testErrstr()
    {
        $this->assertEquals('Success', $this->message->errstr());
    }
}
