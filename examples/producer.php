<?php

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\Message;
use RdKafka\Producer;
use RdKafka\TopicConf;

require_once dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);

$conf = new Conf();
$conf->set('metadata.broker.list', 'kafka:9092');
$conf->set('socket.timeout.ms', (string) 50);
$conf->set('queue.buffering.max.messages', (string) 1000);
$conf->set('max.in.flight.requests.per.connection', (string) 1);
$conf->set('log_level', (string) LOG_DEBUG);
$conf->setDrMsgCb(
    function (Producer $producer, Message $message): void {
        if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            var_dump($message->errstr());
        }
        var_dump($message);
    }
);

$conf->set('debug', 'all');
$conf->setLogCb(
    function ($producer, $level, $fac, $buf): void {
        echo "log: ${level} ${fac} ${buf}" . PHP_EOL;
    }
);

$conf->set('statistics.interval.ms', (string) 10);
$conf->setStatsCb(
    function ($consumer, $json, $json_len, $opaque): void {
        echo "stats: ${json}" . PHP_EOL;
    }
);

$topicConf = new TopicConf();
$topicConf->set('message.timeout.ms', (string) 30000);
$topicConf->set('request.required.acks', (string) -1);
$topicConf->set('request.timeout.ms', (string) 5000);
var_dump($topicConf->dump());

if (function_exists('pcntl_sigprocmask')) {
    pcntl_sigprocmask(SIG_BLOCK, [SIGIO]);
    $conf->set('internal.termination.signal', (string) SIGIO);
} else {
    $conf->set('queue.buffering.max.ms', (string) 1);
}
var_dump($conf->dump());

$producer = new Producer($conf);

$topic = $producer->newTopic('playground', $topicConf);
var_dump($topic);

$metadata = $producer->getMetadata(false, $topic, 1000);
var_dump($metadata->getOrigBrokerName());
var_dump($metadata->getOrigBrokerId());
var_dump($metadata->getBrokers());
var_dump($metadata->getTopics());

for ($i = 0; $i < 1000; $i++) {
    $key = $i % 10;
    $payload = "payload-${i}-key-${key}";
    echo sprintf('produce msg: %s', $payload) . PHP_EOL;
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload, (string) $key);
    $events = $producer->poll(1); // triggers log output
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
}

$producer->flush(5000);
