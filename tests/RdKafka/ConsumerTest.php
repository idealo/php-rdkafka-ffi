<?php
declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Consumer
 * @covers \RdKafka\Conf
 * @covers \RdKafka
 */
class ConsumerTest extends TestCase
{
    public function testAddBrokers()
    {
        $consumer = new Consumer();
        $addedBrokersNumber = $consumer->addBrokers(KAFKA_BROKERS);

        $this->assertEquals(1, $addedBrokersNumber);
    }

    /**
     * @group ffiOnly
     */
    public function testGetCData()
    {
        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);

        $cData = $consumer->getCData();

        $this->assertInstanceOf(CData::class, $cData);
    }

    public function testGetMetadata()
    {
        $consumer = new Consumer();
        $consumer->addBrokers(KAFKA_BROKERS);
        $metadata = $consumer->getMetadata(true, null, (int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertInstanceOf(Metadata::class, $metadata);
    }

    /**
     * @group ffiOnly
     */
    public function testGetOutQLen()
    {
        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->setLogCb(function ($consumer, $level, $fac, $buf) {
//            echo "log: $level $fac $buf" . PHP_EOL;
        });

        $consumer = new Consumer($conf);
        $outQLen = $consumer->getOutQLen();

        // expect init log msg
        $this->assertEquals(1, $outQLen, 'Expected log event init consumer');
    }

    public function testNewQueue()
    {
        $consumer = new Consumer();
        $queue = $consumer->newQueue();

        $this->assertInstanceOf(Queue::class, $queue);
    }

    public function testNewTopic()
    {
        $consumer = new Consumer();
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->assertInstanceOf(ConsumerTopic::class, $topic);
    }

    /**
     * @group ffiOnly
     */
    public function testPoll()
    {
        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->setLogCb(function (Consumer $consumer, int $level, string $fac, string $buf) {
//            echo "log: $level $fac $buf" . PHP_EOL;
        });

        $consumer = new Consumer($conf);
        $triggeredEvents = $consumer->poll(0);

        $this->assertEquals(1, $triggeredEvents, 'Expected log event init consumer');
    }

    /**
     * @group ffiOnly
     */
    public function testSetLogLevelWithDebug()
    {
        $loggerCallbacks = 0;

        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->setLogCb(function (Consumer $consumer, int $level, string $fac, string $buf) use (&$loggerCallbacks) {
//            echo "log: $level $fac $buf" . PHP_EOL;
            $loggerCallbacks++;
        });

        $consumer = new Consumer($conf);
        $consumer->setLogLevel(LOG_DEBUG);

        $triggeredEvents = $consumer->poll(0);
        $this->assertEquals(1, $triggeredEvents, 'Expected debug level log event init consumer');
        $this->assertEquals(1, $loggerCallbacks, 'Expected debug level log callback');
    }

    /**
     * @group ffiOnly
     */
    public function testSetLogLevelWithInfo()
    {
        $loggerCallbacks = 0;

        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->setLogCb(function (Consumer $consumer, int $level, string $fac, string $buf) use (&$loggerCallbacks) {
//            echo "log: $level $fac $buf" . PHP_EOL;
            $loggerCallbacks++;
        });

        $consumer = new Consumer($conf);
        $consumer->setLogLevel(LOG_INFO);
        $triggeredEvents = $consumer->poll(0);

        $this->assertEquals(1, $triggeredEvents, 'Expected debug level log event init consumer');
        $this->assertEquals(0, $loggerCallbacks, 'Expected no debug level log callback');
    }

    public function testQueryWatermarkOffsets()
    {
        $consumer1 = new Consumer();
        $consumer1->addBrokers(KAFKA_BROKERS);

        $lowWatermarkOffset1 = 0;
        $highWatermarkOffset1 = 0;

        $consumer1->queryWatermarkOffsets(KAFKA_TEST_TOPIC, 0, $lowWatermarkOffset1, $highWatermarkOffset1, (int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertEquals(0, $lowWatermarkOffset1);

        $producer = new Producer();
        $producer->addBrokers(KAFKA_BROKERS);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->poll((int)KAFKA_TEST_TIMEOUT_MS);

        $lowWatermarkOffset2 = 0;
        $highWatermarkOffset2 = 0;

        $consumer1->queryWatermarkOffsets(KAFKA_TEST_TOPIC, 0, $lowWatermarkOffset2, $highWatermarkOffset2, (int)KAFKA_TEST_TIMEOUT_MS);

        $this->assertEquals(0, $lowWatermarkOffset2);
        $this->assertEquals($highWatermarkOffset1 + 1, $highWatermarkOffset2);
    }

    /**
     * @group ffiOnly
     */
    public function testResolveFromCData()
    {
        $consumer1 = new Consumer();
        $cData1 = $consumer1->getCData();

        $consumer2 = new Consumer();
        $cData2 = $consumer2->getCData();

        $this->assertEquals($consumer1, Consumer::resolveFromCData($cData1));
        $this->assertEquals($consumer2, Consumer::resolveFromCData($cData2));

        unset($consumer1);

        $this->assertNull(Consumer::resolveFromCData($cData1));
        $this->assertEquals($consumer2, Consumer::resolveFromCData($cData2));
    }
}
