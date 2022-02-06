<?php

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\TopicConf;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$conf = new Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('group.id', 'test');
//$conf->set('log_level', (string) LOG_DEBUG);
//$conf->set('debug', 'all');
$conf->setLogCb(
    function (Consumer $consumer, int $level, string $facility, string $message): void {
        echo sprintf('  log: %d %s %s', $level, $facility, $message) . PHP_EOL;
    }
);

$conf->set('statistics.interval.ms', (string) 1000);
$conf->setStatsCb(
    function (Consumer $consumer, string $json, int $jsonLength, $opaque): void {
        echo "stats: ${json}" . PHP_EOL;
    }
);

$topicConf = new TopicConf();
$topicConf->set('enable.auto.commit', 'true');
$topicConf->set('auto.commit.interval.ms', (string) 100);
$topicConf->set('auto.offset.reset', 'earliest');
var_dump($topicConf->dump());

$consumer = new Consumer($conf);

$topic = $consumer->newTopic('playground', $topicConf);
var_dump($topic);

$queue = $consumer->newQueue();
$topic->consumeQueueStart(0, RD_KAFKA_OFFSET_BEGINNING, $queue);
$topic->consumeQueueStart(1, RD_KAFKA_OFFSET_BEGINNING, $queue);
$topic->consumeQueueStart(2, RD_KAFKA_OFFSET_BEGINNING, $queue);
do {
    $message = $queue->consume(1000);
    if ($message === null) {
        break;
    }
    echo sprintf('consume msg: %s, timestamp: %s, brokerId: %s', $message->payload, $message->timestamp, $message->brokerId) . PHP_EOL;
    // triggers log output
    $events = $consumer->poll(1);
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
} while (true);
$topic->consumeStop(0);
$topic->consumeStop(1);
$topic->consumeStop(2);
