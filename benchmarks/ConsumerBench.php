<?php

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\Producer;

/**
 * @Groups({"Consumer"})
 * @BeforeClassMethods({"produce10000Messages"})
 */
class ConsumerBench
{
    public static function produce10000Messages(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $producer = new Producer($conf);
        $topic = $producer->newTopic('benchmarks');

        for ($i = 0; $i < 10000; $i++) {
            $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'bench', 'mark');
        }

        $producer->flush(5000);
    }

    /**
     * @Warmup(1)
     * @Revs(100)
     * @Iterations(5)
     * @Groups({"ffi", "ext"})
     */
    public function benchConsume1Message(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('auto.offset.reset', 'earliest');
        $conf->set('log_level', (string) 0);
        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic('benchmarks');

        $topic->consumeStart(0, 0);
        $messages = 0;
        do {
            $message = $topic->consume(0, 500);
            if ($message === null) {
                break;
            }
            if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
                continue;
            }
            $messages++;
        } while ($messages <= 1);

        $topic->consumeStop(0);

        if ($messages < 1) {
            throw new Exception('failed to consume 1 message');
        }
    }

    /**
     * @Warmup(1)
     * @Revs(100)
     * @Iterations(5)
     * @Groups({"ffi", "ext"})
     */
    public function benchConsume100Messages(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('auto.offset.reset', 'earliest');
        $conf->set('log_level', (string) 0);
        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic('benchmarks');

        $topic->consumeStart(0, 0);
        $messages = 0;
        do {
            $message = $topic->consume(0, 500);
            if ($message === null) {
                break;
            }
            if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
                continue;
            }
            $messages++;
        } while ($messages <= 100);

        $topic->consumeStop(0);

        if ($messages < 100) {
            throw new Exception('failed to consume 100 messages');
        }
    }

    /**
     * @Warmup(1)
     * @Revs(100)
     * @Iterations(5)
     * @Groups({"ffi", "ext"})
     */
    public function benchConsume100MessagesWithLogCallback(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('auto.offset.reset', 'earliest');
        $conf->set('log_level', (string) LOG_DEBUG);
        $conf->set('debug', 'consumer,cgrp,topic,fetch');
        $conf->setLogCb(
            function (Consumer $consumer, int $level, string $facility, string $message): void {
                // echo sprintf('log: %d %s %s', $level, $facility, $message) . PHP_EOL;
            }
        );
        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic('benchmarks');

        $topic->consumeStart(0, 0);
        $messages = 0;
        do {
            $message = $topic->consume(0, 500);
            if ($message === null) {
                break;
            }
            if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
                continue;
            }
            $messages++;
        } while ($messages <= 100);

        $topic->consumeStop(0);

        if ($messages < 100) {
            throw new Exception('failed to consume 100 messages');
        }
    }

    /**
     * @Warmup(1)
     * @Revs(100)
     * @Iterations(5)
     * @Groups({"ffi", "ext"})
     */
    public function benchConsumeBatch100Messages(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('auto.offset.reset', 'earliest');
        $conf->set('log_level', (string) 0);
        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic('benchmarks');

        $topic->consumeStart(0, 0);
        $messages = $topic->consumeBatch(0, 500, 100);
        $topic->consumeStop(0);

        if (count($messages) < 100) {
            throw new Exception('failed to consume 100 messages');
        }
    }
}
