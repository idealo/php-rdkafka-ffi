<?php

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\Message;
use RdKafka\Producer;

/**
 * @Groups({"Producer"})
 */
class ProducerBench
{
    /**
     * @Warmup(1)
     * @Revs(100)
     * @Iterations(5)
     * @Groups({"ffi", "ext"})
     */
    public function benchProduce1Message(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('batch.num.messages', (string) 1);
        $conf->set('log_level', (string) 0);
        $producer = new Producer($conf);
        $topic = $producer->newTopic('benchmarks');

        $topic->produce(0, 0, 'bench', 'mark');

        while ($producer->getOutQLen() > 0) {
            $producer->poll(0);
        }
    }

    /**
     * @Warmup(1)
     * @Revs(100)
     * @Iterations(5)
     * @Groups({"ffi", "ext"})
     */
    public function benchProduce100Messages(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('batch.num.messages', (string) 100);
        $conf->set('log_level', (string) 0);
        $producer = new Producer($conf);
        $topic = $producer->newTopic('benchmarks');

        for ($i = 0; $i < 100; $i++) {
            $topic->produce(0, 0, 'bench', 'mark');
        }

        while ($producer->getOutQLen() > 0) {
            $producer->poll(0);
        }
    }

    /**
     * @Warmup(1)
     * @Revs(100)
     * @Iterations(5)
     * @Groups({"ffi", "ext"})
     */
    public function benchProduce100MessagesWithLogAndDrMsgCallbacks(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('batch.num.messages', (string) 100);
        $conf->set('debug', 'broker,topic,msg');
        $conf->set('log_level', (string) LOG_DEBUG);
        $conf->setLogCb(
            function (Producer $producer, int $level, string $facility, string $message): void {
                // echo sprintf('log: %d %s %s', $level, $facility, $message) . PHP_EOL;
            }
        );
        $deliveryCallback = new class() {
            public int $messages = 0;

            public function __invoke(Producer $producer, Message $message, $opaque = null): void
            {
                $this->messages++;
            }
        };
        $conf->setDrMsgCb($deliveryCallback);
        $producer = new Producer($conf);
        $topic = $producer->newTopic('benchmarks');

        for ($i = 0; $i < 100; $i++) {
            $topic->produce(0, 0, 'bench', 'mark');
        }

        while ($deliveryCallback->messages < 100) {
            $producer->poll(0);
        }
    }

    /**
     * @Warmup(1)
     * @Revs(100)
     * @Iterations(5)
     * @Groups({"ffi"})
     */
    public function benchProduce100MessagesWithLogAndDrMsgCallbacksWithOpaque(): void
    {
        $counter = new stdClass();
        $counter->count = 0;

        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('batch.num.messages', (string) 100);
        $conf->set('debug', 'broker,topic,msg');
        $conf->set('log_level', (string) LOG_DEBUG);
        $conf->setOpaque($counter);
        $conf->setLogCb(
            function (Producer $producer, int $level, string $facility, string $message): void {
                // echo sprintf('log: %d %s %s', $level, $facility, $message) . PHP_EOL;
            }
        );
        $deliveryCallback = new class() {
            public function __invoke(Producer $producer, Message $message, $opaque = null): void
            {
                $opaque->count += $message->opaque;
            }
        };
        $conf->setDrMsgCb($deliveryCallback);
        $producer = new Producer($conf);
        $topic = $producer->newTopic('benchmarks');

        for ($i = 0; $i < 100; $i++) {
            $topic->produce(0, 0, 'bench', 'mark', 1);
        }

        while ($counter->count < 100) {
            $producer->poll(0);
        }
    }
}
