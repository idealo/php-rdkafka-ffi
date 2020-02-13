<?php

declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;
use RdKafka;

/**
 * @covers \RdKafka\Producer
 * @covers \RdKafka
 */
class ProducerTest extends TestCase
{
    private Producer $producer;

    private string $callbackPayload;

    protected function setUp(): void
    {
        $this->callbackPayload = '';
        $conf = new Conf();
        $conf->setDrMsgCb(
            function (RdKafka $kafka, Message $message, $opaque = null): void {
                $this->callbackPayload = $message->payload;
            }
        );

        $this->producer = new Producer($conf);
        $this->producer->addBrokers(KAFKA_BROKERS);
    }

    public function testAddBrokers(): void
    {
        $addedBrokersNumber = $this->producer->addBrokers(KAFKA_BROKERS);

        self::assertSame(1, $addedBrokersNumber);
    }

    public function testGetMetadata(): void
    {
        $metadata = $this->producer->getMetadata(true, null, KAFKA_TEST_TIMEOUT_MS);

        self::assertInstanceOf(Metadata::class, $metadata);
    }

    public function testGetOutQLen(): void
    {
        $outQLen = $this->producer->getOutQLen();

        self::assertSame(0, $outQLen);
    }

    public function testNewTopic(): void
    {
        $topic = $this->producer->newTopic(KAFKA_TEST_TOPIC);

        self::assertInstanceOf(ProducerTopic::class, $topic);
    }

    public function testPoll(): void
    {
        $topic = $this->producer->newTopic(KAFKA_TEST_TOPIC);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, __METHOD__);

        $this->producer->poll(100);

        self::assertSame(__METHOD__, $this->callbackPayload);
    }

    /**
     * @group ffiOnly
     */
    public function testResolveFromCData(): void
    {
        $producer1 = new Producer();
        $cData1 = $producer1->getCData();

        $producer2 = new Producer();
        $cData2 = $producer2->getCData();

        $this->assertSame($producer1, Producer::resolveFromCData($cData1));
        $this->assertSame($producer2, Producer::resolveFromCData($cData2));

        unset($producer1);

        $this->assertNull(Producer::resolveFromCData($cData1));
        $this->assertSame($producer2, Producer::resolveFromCData($cData2));
    }

    public function testFlush(): void
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $res = $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $this->assertSame(0, $res);
    }
}
