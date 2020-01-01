<?php

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\TopicConf;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$conf = new Conf();
$conf->set('metadata.broker.list', 'kafka:9092');
$conf->set('group.id', 'test');
$conf->set('log_level', (string) LOG_DEBUG);
$conf->set('debug', 'all');
$conf->setLogCb(
    function ($consumer, $level, $fac, $buf): void {
        echo "log: ${level} ${fac} ${buf}" . PHP_EOL;
    }
);

$conf->set('statistics.interval.ms', (string) 500);
$conf->setStatsCb(
    function ($consumer, $json, $json_len, $opaque): void {
        echo "stats: ${json}" . PHP_EOL;
    }
);

$topicConf = new TopicConf();
$topicConf->set('enable.auto.commit', 'true');
$topicConf->set('auto.commit.interval.ms', (string) 100);
$topicConf->set('auto.offset.reset', 'earliest');
var_dump($topicConf->dump());

if (function_exists('pcntl_sigprocmask')) {
    pcntl_sigprocmask(SIG_BLOCK, [SIGIO]);
    $conf->set('internal.termination.signal', (string) SIGIO);
} else {
    $conf->set('queue.buffering.max.ms', (string) 1);
}
var_dump($conf->dump());

$consumer = new Consumer($conf);

$topic = $consumer->newTopic('playground', $topicConf);
var_dump($topic);

$queue = $consumer->newQueue();
$topic->consumeQueueStart(0, RD_KAFKA_OFFSET_BEGINNING, $queue);
$topic->consumeQueueStart(1, RD_KAFKA_OFFSET_BEGINNING, $queue);
$topic->consumeQueueStart(2, RD_KAFKA_OFFSET_BEGINNING, $queue);
while ($message = $queue->consume(1000)) {
    echo sprintf('consume msg: %s, ts: %s', $message->payload, $message->timestamp) . PHP_EOL;
    $events = $consumer->poll(1); // triggers log output
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
}
$topic->consumeStop(0);
$topic->consumeStop(1);
$topic->consumeStop(2);
