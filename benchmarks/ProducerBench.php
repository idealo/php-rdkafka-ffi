<?php

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\Message;
use RdKafka\Producer;

/**
 * @Groups({"Producer", "ffi", "ext"})
 */
class ProducerBench
{
    /**
     * @Warmup(1)
     * @Revs(100)
     * @Iterations(5)
     */
    public function benchProduce1Message(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
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
     */
    public function benchProduce100Messages(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('batch.num.messages', (string) 100);
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
     */
    public function benchProduce100MessagesWithLogAndDrMsgCallbacks(): void
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('batch.num.messages', (string) 100);
        $conf->set('debug', 'all');
        $conf->setLogCb(
            function (Producer $producer, int $level, string $fac, string $buf): void {
                // echo "log: $level $fac $buf" . PHP_EOL;
            }
        );
        $conf->setDrMsgCb(
            function (Producer $producer, Message $message, $opaque = null): void {
                // do nothing
            }
        );
        $producer = new Producer($conf);
        $topic = $producer->newTopic('benchmarks');

        for ($i = 0; $i < 100; $i++) {
            $topic->produce(0, 0, 'bench', 'mark');
        }

        while ($producer->getOutQLen() > 0) {
            $producer->poll(0);
        }
    }
}
