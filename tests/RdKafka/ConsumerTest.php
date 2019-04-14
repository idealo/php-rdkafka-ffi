<?php
declare(strict_types=1);

namespace RdKafka;

use FFI\CData;
use PHPUnit\Framework\TestCase;

/**
 * @covers \RdKafka\Consumer
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
        $metadata = $consumer->getMetadata(true, null, 2000);

        $this->assertInstanceOf(Metadata::class, $metadata);
    }

    public function testGetOutQLen()
    {
        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->setLoggerCb(function ($consumer, $level, $fac, $buf) {
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
        $this->assertInstanceOf(CData::class, $queue->getCData());
    }

    public function testNewTopic()
    {
        $consumer = new Consumer();
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->assertInstanceOf(ConsumerTopic::class, $topic);
    }

    public function testPoll()
    {
        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->setLoggerCb(function (Consumer $consumer, int $level, string $fac, string $buf) {
//            echo "log: $level $fac $buf" . PHP_EOL;
        });

        $consumer = new Consumer($conf);
        $triggeredEvents = $consumer->poll(0);

        $this->assertEquals(1, $triggeredEvents, 'Expected log event init consumer');
    }

    public function testSetLogLevelWithDebug()
    {
        $loggerCallbacks = 0;

        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->setLoggerCb(function (Consumer $consumer, int $level, string $fac, string $buf) use (&$loggerCallbacks) {
//            echo "log: $level $fac $buf" . PHP_EOL;
            $loggerCallbacks++;
        });

        $consumer = new Consumer($conf);
        $consumer->setLogLevel(LOG_DEBUG);

        $triggeredEvents = $consumer->poll(0);
        $this->assertEquals(1, $triggeredEvents, 'Expected debug level log event init consumer');
        $this->assertEquals(1, $loggerCallbacks, 'Expected debug level log callback');
    }

    public function testSetLogLevelWithInfo()
    {
        $loggerCallbacks = 0;

        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->setLoggerCb(function (Consumer $consumer, int $level, string $fac, string $buf) use (&$loggerCallbacks) {
//            echo "log: $level $fac $buf" . PHP_EOL;
            $loggerCallbacks++;
        });

        $consumer = new Consumer($conf);
        $consumer->setLogLevel(LOG_INFO);
        $triggeredEvents = $consumer->poll(0);

        $this->assertEquals(1, $triggeredEvents, 'Expected debug level log event init consumer');
        $this->assertEquals(0, $loggerCallbacks, 'Expected no debug level log callback');
    }
}
