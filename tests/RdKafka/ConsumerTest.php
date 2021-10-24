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
    public function testAddBrokers(): void
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);

        $consumer = new Consumer($conf);
        $addedBrokersNumber = $consumer->addBrokers(KAFKA_BROKERS);

        $this->assertSame(1, $addedBrokersNumber);
    }

    /**
     * @group ffiOnly
     */
    public function testGetCData(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumer = new Consumer($conf);

        $cData = $consumer->getCData();

        $this->assertInstanceOf(CData::class, $cData);
    }

    public function testGetMetadata(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $consumer = new Consumer($conf);

        $metadata = $consumer->getMetadata(true, null, KAFKA_TEST_TIMEOUT_MS);

        $this->assertInstanceOf(Metadata::class, $metadata);
    }

    /**
     * @group ffiOnly
     */
    public function testGetOutQLen(): void
    {
        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setLogCb(
            function ($consumer, $level, $fac, $buf): void {
//            echo "log: $level $fac $buf" . PHP_EOL;
            }
        );

        $consumer = new Consumer($conf);
        $outQLen = $consumer->getOutQLen();

        // expect init log msg
        $this->assertGreaterThan(0, $outQLen, 'Expected debug level log events on consumer init');
    }

    public function testNewQueue(): void
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);

        $consumer = new Consumer($conf);
        $queue = $consumer->newQueue();

        $this->assertInstanceOf(Queue::class, $queue);
    }

    public function testNewTopic(): void
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);

        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic(KAFKA_TEST_TOPIC);

        $this->assertInstanceOf(ConsumerTopic::class, $topic);
    }

    /**
     * @group ffiOnly
     */
    public function testPoll(): void
    {
        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setLogCb(
            function (Consumer $consumer, int $level, string $facility, string $message): void {
                // echo sprintf('log: %d %s %s', $level, $facility, $message) . PHP_EOL;
            }
        );

        $consumer = new Consumer($conf);
        $triggeredEvents = $consumer->poll(0);

        $this->assertGreaterThan(0, $triggeredEvents, 'Expected debug level log events on consumer init');
    }

    /**
     * @group ffiOnly
     */
    public function testSetLogLevelWithDebug(): void
    {
        $loggerCallbacks = 0;

        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setLogCb(
            function (Consumer $consumer, int $level, string $facility, string $message) use (&$loggerCallbacks): void {
                // echo sprintf('log: %d %s %s', $level, $facility, $message) . PHP_EOL;
                $loggerCallbacks++;
            }
        );

        $consumer = new Consumer($conf);
        $consumer->setLogLevel(LOG_DEBUG);

        $triggeredEvents = $consumer->poll(0);
        $this->assertGreaterThan(0, $triggeredEvents, 'Expected debug level log events on consumer init');
        $this->assertSame($triggeredEvents, $loggerCallbacks, 'Expected debug level log callback calls same as log events');
    }

    /**
     * @group ffiOnly
     */
    public function testSetLogLevelWithInfo(): void
    {
        $loggerCallbacks = 0;

        $conf = new Conf();
        $conf->set('debug', 'consumer');
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->setLogCb(
            function (Consumer $consumer, int $level, string $facility, string $message) use (&$loggerCallbacks): void {
                // echo sprintf('log: %d %s %s', $level, $facility, $message) . PHP_EOL;
                $loggerCallbacks++;
            }
        );

        $consumer = new Consumer($conf);
        $consumer->setLogLevel(LOG_INFO);
        $triggeredEvents = $consumer->poll(0);

        $this->assertGreaterThan(0, $triggeredEvents, 'Expected debug level log events on consumer init');
        $this->assertSame(0, $loggerCallbacks, 'Expected no debug level log callback');
    }

    public function testQueryWatermarkOffsets(): void
    {
        $conf = new Conf();
        $conf->set('bootstrap.servers', KAFKA_BROKERS);
        $conf->set('topic.metadata.refresh.interval.ms', (string) 900);
        $consumer = new Consumer($conf);

        // wait for meta data refresh
        sleep(1);

        $lowWatermarkOffset1 = 0;
        $highWatermarkOffset1 = 0;

        $consumer->queryWatermarkOffsets(
            KAFKA_TEST_TOPIC,
            0,
            $lowWatermarkOffset1,
            $highWatermarkOffset1,
            KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertSame(0, $lowWatermarkOffset1);

        $producerConf = new Conf();
        $producerConf->set('bootstrap.servers', KAFKA_BROKERS);
        $producer = new Producer($producerConf);
        $producerTopic = $producer->newTopic(KAFKA_TEST_TOPIC);
        $producerTopic->produce(0, 0, __METHOD__);
        $producer->flush(KAFKA_TEST_TIMEOUT_MS);

        $lowWatermarkOffset2 = 0;
        $highWatermarkOffset2 = 0;

        $consumer->queryWatermarkOffsets(
            KAFKA_TEST_TOPIC,
            0,
            $lowWatermarkOffset2,
            $highWatermarkOffset2,
            KAFKA_TEST_TIMEOUT_MS
        );

        $this->assertSame(0, $lowWatermarkOffset2);
        $this->assertSame($highWatermarkOffset1 + 1, $highWatermarkOffset2);
    }

    /**
     * @group ffiOnly
     */
    public function testResolveFromCData(): void
    {
        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);

        $consumer1 = new Consumer($conf);
        $cData1 = $consumer1->getCData();

        $consumer2 = new Consumer($conf);
        $cData2 = $consumer2->getCData();

        $this->assertSame($consumer1, Consumer::resolveFromCData($cData1));
        $this->assertSame($consumer2, Consumer::resolveFromCData($cData2));

        unset($consumer1);

        $this->assertNull(Consumer::resolveFromCData($cData1));
        $this->assertSame($consumer2, Consumer::resolveFromCData($cData2));
    }

    /**
     * @group ffiOnly
     */
    public function testGetOpaque(): void
    {
        $expectedOpaque = new \stdClass();

        $conf = new Conf();
        $conf->set('log_level', (string) LOG_EMERG);
        $conf->setOpaque($expectedOpaque);

        $consumer = new Consumer($conf);
        $this->assertSame($expectedOpaque, $consumer->getOpaque());
    }
}
