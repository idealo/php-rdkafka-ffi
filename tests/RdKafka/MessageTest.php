<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Message
 */
class MessageTest extends TestCase
{
    use \RequireVersionTrait;

    private ?Message $message;
    private Message $producedMessage;
    private float $expectedLatencyInSeconds;
    private int $beforeProducingTimestamp;

    protected function prepareMessage(...$params): void
    {
        $this->beforeProducingTimestamp = time();

        $context = $this;
        $producerConf = new Conf();
        $producerConf->set('bootstrap.servers', KAFKA_BROKERS);
        $producerConf->setDrMsgCb(
            function ($producer, $message) use ($context): void {
                $context->producedMessage = $message;
                $context->expectedLatencyInSeconds = microtime(true) - $context->expectedLatencyInSeconds;
            }
        );
        $producer = new Producer($producerConf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $this->expectedLatencyInSeconds = microtime(true);
        $producerTopic->producev(...$params);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $consumerConf = new Conf();
        $consumerConf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumer = new Consumer($consumerConf);
        $consumerTopic = $consumer->newTopic(KAFKA_TEST_TOPIC);
        $consumerTopic->consumeStart(0, rd_kafka_offset_tail(1));

        $this->message = $consumerTopic->consume(0, (int) KAFKA_TEST_TIMEOUT_MS);

        $consumerTopic->consumeStop(0);
    }

    public function testProperties(): void
    {
        $this->prepareMessage(0, 0, __METHOD__ . '1', 'key-üöäß-👻', [
            'name-üöäß-👻' => 'value-üöäß-👻',
        ]);

        $this->assertSame(RD_KAFKA_RESP_ERR_NO_ERROR, $this->message->err);
        $this->assertSame(KAFKA_TEST_TOPIC, $this->message->topic_name);
        $this->assertSame(0, $this->message->partition);
        $this->assertSame(__METHOD__ . '1', $this->message->payload);
        $this->assertSame('key-üöäß-👻', $this->message->key);
        $this->assertSame([
            'name-üöäß-👻' => 'value-üöäß-👻',
        ], $this->message->headers);
        $this->assertGreaterThan(0, $this->message->offset);

        $this->prepareMessage(0, 0, null);

        $this->assertNull($this->message->payload);
        $this->assertNull($this->message->key);
        $this->assertSame([], $this->message->headers);

        $this->prepareMessage(0, 0, __METHOD__ . '3', gzencode('123'), [
            'no_null_byte' => gzencode('456'),
        ]);

        $this->assertSame(__METHOD__ . '3', $this->message->payload);
        $this->assertSame(gzencode('123'), $this->message->key);
        $this->assertSame([
            'no_null_byte' => gzencode('456'),
        ], $this->message->headers);
    }

    /**
     * @group ffiOnly
     */
    public function testPropertyTimestamp(): void
    {
        $this->prepareMessage(0, 0, __METHOD__);

        $this->assertSame(__METHOD__, $this->message->payload);
        $this->assertGreaterThan($this->beforeProducingTimestamp, $this->message->timestamp);
        $this->assertSame(1 /*RD_KAFKA_TIMESTAMP_CREATE_TIME*/, $this->message->timestampType);
    }

    /**
     * @group ffiOnly
     */
    public function testPropertyStatus(): void
    {
        $this->prepareMessage(0, 0, __METHOD__);

        $this->assertSame(__METHOD__, $this->message->payload);
        $this->assertSame(RD_KAFKA_MSG_STATUS_PERSISTED, $this->message->status);
    }

    /**
     * @group ffiOnly
     */
    public function testPropertyLatency(): void
    {
        $this->prepareMessage(0, 0, __METHOD__);

        $expectedLatencyInMicroseconds = $this->expectedLatencyInSeconds * 1000 * 1000;

        $this->assertSame(__METHOD__, $this->message->payload);
        $this->assertGreaterThan($expectedLatencyInMicroseconds - 2000, $this->producedMessage->latency);
        $this->assertLessThan($expectedLatencyInMicroseconds + 2000, $this->producedMessage->latency);
    }

    public function testErrstr(): void
    {
        $this->prepareMessage(0, 0, __METHOD__);

        $this->assertSame(__METHOD__, $this->message->payload);
        $this->assertSame('Success', $this->message->errstr());
    }

    /**
     * @group ffiOnly
     */
    public function testBrokerId(): void
    {
        $this->requiresLibrdkafkaVersion('>=', '1.5.0');

        $this->prepareMessage(0, 0, __METHOD__);

        $this->assertSame(__METHOD__, $this->message->payload);
        $this->assertSame(KAFKA_BROKER_ID, $this->message->brokerId);
    }
}
