<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);

$conf = new \RdKafka\Conf();
$conf->set('socket.timeout.ms', (string)50);
$conf->set('queue.buffering.max.messages', (string)1000);
$conf->set('max.in.flight.requests.per.connection', (string)1);
$conf->setDrMsgCb(function (\RdKafka\Producer $producer, \RdKafka\Message $message) {
    if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
        var_dump($message->errstr());
    }
    var_dump($message);
});

$conf->set('debug', 'all');
$conf->setLoggerCb(function ($producer, $level, $fac, $buf) {
    echo "log: $level $fac $buf" . PHP_EOL;
});

$conf->set('statistics.interval.ms', 10);
$conf->setStatsCb(function ($consumer, $json, $json_len, $opaque) {
    echo "stats: $json" . PHP_EOL;
});

$topicConf = new \RdKafka\TopicConf();
$topicConf->set('message.timeout.ms', (string)30000);
$topicConf->set('request.required.acks', (string)-1);
$topicConf->set('request.timeout.ms', (string)5000);
var_dump($topicConf->dump());
$conf->setDefaultTopicConf($topicConf);

if (function_exists('pcntl_sigprocmask')) {
    pcntl_sigprocmask(SIG_BLOCK, [SIGIO]);
    $conf->set('internal.termination.signal', SIGIO);
} else {
    $conf->set('queue.buffering.max.ms', 1);
}
var_dump($conf->dump());

$producer = new \RdKafka\Producer($conf);
$producer->setLogLevel(LOG_DEBUG);
$added = $producer->addBrokers('kafka:9092');
var_dump($added);

$topic = $producer->newTopic('playground'); //, $topicConf);
var_dump($topic);

$metadata = $producer->getMetadata(false, $topic, 1000);
var_dump($metadata->getOrigBrokerName());
var_dump($metadata->getOrigBrokerId());
var_dump($metadata->getBrokers());
var_dump($metadata->getTopics());

for ($i = 0; $i < 1000; $i++) {
    $key = $i % 10;
    $payload = "payload-$i-key-$key";
    echo sprintf('produce msg: %s', $payload) . PHP_EOL;
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload, (string) $key);
    $events = $producer->poll(1); // triggers log output
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
}
