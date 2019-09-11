<?php
declare(strict_types=1);

namespace RdKafka;

use PHPUnit\Framework\TestCase;
use RdKafka;

/**
 * @covers \RdKafka\Producer
 * @covers \RdKafka\Conf
 * @covers \RdKafka
 */
class ProducerTest extends TestCase
{
    /**
     * @var Producer
     */
    private $producer;

    private $callbackPayload;

    protected function setUp(): void
    {
        $this->callbackPayload = '';
        $conf = new Conf();
        $conf->setDrMsgCb(function (RdKafka $kafka, Message $message, $opaque = null) {
            $this->callbackPayload = $message->payload;
        });

        $this->producer = new Producer($conf);
        $this->producer->addBrokers(KAFKA_BROKERS);
    }

    public function testAddBrokers()
    {
        $addedBrokersNumber = $this->producer->addBrokers(KAFKA_BROKERS);

        self::assertEquals(1, $addedBrokersNumber);
    }

    public function testGetMetadata()
    {
        $metadata = $this->producer->getMetadata(true, null, (int)KAFKA_TEST_TIMEOUT_MS);

        self::assertInstanceOf(Metadata::class, $metadata);
    }

    public function testGetOutQLen()
    {
        $outQLen = $this->producer->getOutQLen();

        self::assertEquals(0, $outQLen);
    }

    public function testNewTopic()
    {
        $topic = $this->producer->newTopic(KAFKA_TEST_TOPIC);

        self::assertInstanceOf(ProducerTopic::class, $topic);
    }

    public function testPoll()
    {
        $topic = $this->producer->newTopic(KAFKA_TEST_TOPIC);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, __METHOD__);

        $this->producer->poll(100);

        self::assertEquals(__METHOD__, $this->callbackPayload);
    }

    /**
     * @group ffiOnly
     */
    public function testResolveFromCData()
    {
        $producer1 = new Producer();
        $cData1 = $producer1->getCData();

        $producer2 = new Producer();
        $cData2 = $producer2->getCData();

        $this->assertEquals($producer1, Producer::resolveFromCData($cData1));
        $this->assertEquals($producer2, Producer::resolveFromCData($cData2));

        unset($producer1);

        $this->assertNull(Producer::resolveFromCData($cData1));
        $this->assertEquals($producer2, Producer::resolveFromCData($cData2));
    }

    public function testFlush()
    {
        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $res = $producer->flush((int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertEquals(0, $res);
    }
}
