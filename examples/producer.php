<?php

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\Message;
use RdKafka\Producer;
use RdKafka\TopicConf;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$conf = new Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('socket.timeout.ms', (string) 50);
$conf->set('queue.buffering.max.messages', (string) 1000);
$conf->set('max.in.flight.requests.per.connection', (string) 1);
$conf->setDrMsgCb(
    function (Producer $producer, Message $message): void {
        if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            var_dump($message->errstr());
        }
        var_dump($message);
    }
);
//$conf->set('log_level', (string) LOG_DEBUG);
//$conf->set('debug', 'all');
$conf->setLogCb(
    function (Producer $producer, int $level, string $facility, string $message): void {
        echo sprintf('log: %d %s %s', $level, $facility, $message) . PHP_EOL;
    }
);
$conf->set('statistics.interval.ms', (string) 1000);
$conf->setStatsCb(
    function (Producer $producer, string $json, int $json_len, $opaque): void {
        echo "stats: ${json}" . PHP_EOL;
    }
);
var_dump($conf->dump());

$topicConf = new TopicConf();
$topicConf->set('message.timeout.ms', (string) 30000);
$topicConf->set('request.required.acks', (string) -1);
$topicConf->set('request.timeout.ms', (string) 5000);
var_dump($topicConf->dump());

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
    $payload = sprintf('payload-%d-%s', $i, $key);
    echo sprintf('produce msg: %s', $payload) . PHP_EOL;
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload, (string) $key);
    // triggers log output
    $events = $producer->poll(1);
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
}

$producer->flush(5000);
