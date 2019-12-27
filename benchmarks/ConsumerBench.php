<?php
declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\Producer;

/**
 * @Groups({"Consumer"})
 * @BeforeMethods({"produce10000Messages"})
 */
class ConsumerBench
{
    public function produce10000Messages()
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
     */
    public function benchConsume1Message()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('group.id', __METHOD__);
        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic('benchmarks');

        $topic->consumeStart(0, 0);
        $messages = 0;
        while ($message = $topic->consume(0, 500) && $messages < 1) {
            $messages++;
        }
        $topic->consumeStop(0);

        if ($messages < 1) {
            throw new Exception('failed to consume 1 messages');
        }
    }

    /**
     * @Warmup(1)
     * @Revs(10)
     * @Iterations(5)
     */
    public function benchConsumeCallback1Message()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('group.id', __METHOD__);
        $conf->set('consume.callback.max.messages', (string)1);
        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic('benchmarks');

        $topic->consumeStart(0, 0);
        $messages = 0;
        $callback = function (\RdKafka\Message $message, $opaque = null) use (&$messages) {
            $messages++;
        };
        while ($topic->consumeCallback(0, 500, $callback) && $messages < 1) {
        }
        $topic->consumeStop(0);

        if ($messages < 1) {
            throw new Exception('failed to consume 1 messages');
        }
    }

    /**
     * @Warmup(1)
     * @Revs(100)
     * @Iterations(5)
     */
    public function benchConsume100Messages()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('group.id', __METHOD__);
        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic('benchmarks');

        $topic->consumeStart(0, 0);
        $messages = 0;
        while ($message = $topic->consume(0, 500) && $messages < 100) {
            $messages++;
        }
        $topic->consumeStop(0);

        if ($messages < 100) {
            throw new Exception('failed to consume 100 messages');
        }
    }

    /**
     * @Warmup(1)
     * @Revs(100)
     * @Iterations(5)
     */
    public function benchConsumeBatch100Messages()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('group.id', __METHOD__);
        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic('benchmarks');

        $topic->consumeStart(0, 0);
        $messages = $topic->consumeBatch(0, 500, 100);
        $topic->consumeStop(0);

        if (count($messages) < 100) {
            throw new Exception('failed to consume 100 messages');
        }
    }

    /**
     * @Warmup(1)
     * @Revs(10)
     * @Iterations(5)
     */
    public function benchConsumeCallback100Message()
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', 'kafka:9092');
        $conf->set('group.id', __METHOD__);
        $conf->set('consume.callback.max.messages', (string)100);
        $consumer = new Consumer($conf);
        $topic = $consumer->newTopic('benchmarks');

        $topic->consumeStart(0, 0);
        $messages = 0;
        $callback = function (\RdKafka\Message $message, $opaque = null) use (&$messages) {
            $messages++;
        };
        while ($topic->consumeCallback(0, 500, $callback) && $messages < 100) {
        }
        $topic->consumeStop(0);

        if ($messages < 100) {
            throw new Exception('failed to consume 100 messages');
        }
    }
}
