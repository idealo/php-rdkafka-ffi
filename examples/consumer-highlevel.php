<?php

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\KafkaConsumer;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$conf = new Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('group.id', 'consumer-highlevel');
//$conf->set('log_level', (string)LOG_DEBUG);
//$conf->set('debug', 'consumer,cgrp');
$conf->set('enable.partition.eof', 'true');
if (function_exists('pcntl_sigprocmask')) {
    pcntl_sigprocmask(SIG_BLOCK, [SIGIO]);
    $conf->set('internal.termination.signal', (string) SIGIO);
} else {
    $conf->set('queue.buffering.max.ms', (string) 1);
}
$conf->setLogCb(
    function ($consumer, $level, $fac, $buf): void {
        echo "log: ${level} ${fac} ${buf}" . PHP_EOL;
    }
);

$consumer = new KafkaConsumer($conf);
$consumer->subscribe(['playground']);

while ($message = $consumer->consume(100)) {
    echo sprintf('consume msg: %s, ts: %s', $message->payload, $message->timestamp) . PHP_EOL;

    if ($message->err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
        continue;
    }
    if ($message->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
        continue;
    }

    $consumer->commit($message);
}
