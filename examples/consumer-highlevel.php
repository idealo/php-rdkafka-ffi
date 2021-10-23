<?php

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\KafkaConsumer;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$conf = new Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('group.id', 'consumer-highlevel');
$conf->set('enable.partition.eof', 'true');
$conf->set('auto.offset.reset', 'earliest');
//$conf->set('log_level', (string) LOG_DEBUG);
//$conf->set('debug', 'all');
$conf->setLogCb(
    function (KafkaConsumer $consumer, int $level, string $facility, string $message): void {
        echo sprintf('  log: %d %s %s', $level, $facility, $message) . PHP_EOL;
    }
);

$consumer = new KafkaConsumer($conf);
$consumer->subscribe(['playground']);

do {
    $message = $consumer->consume(100);
    if ($message === null) {
        break;
    }
    echo sprintf('consume msg: %s, ts: %s', $message->payload, $message->timestamp) . PHP_EOL;

    if ($message->err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
        continue;
    }
    if ($message->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
        continue;
    }

    $consumer->commit($message);
} while (true);
