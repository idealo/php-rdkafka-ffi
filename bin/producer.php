<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

error_reporting(E_ALL);

$topicConf = new \RdKafka\TopicConf();
$topicConf->set('message.timeout.ms', (string)30000);
$topicConf->set('request.required.acks', (string)-1);
$topicConf->set('request.timeout.ms', (string)5000);
var_dump($topicConf->dump());

$conf = new \RdKafka\Conf();
$conf->set('socket.timeout.ms', (string)50);
$conf->set('socket.blocking.max.ms', (string)40);
$conf->set('queue.buffering.max.messages', (string)1000);
$conf->set('max.in.flight.requests.per.connection', (string)1);
$conf->set('debug', 'all');
//$conf->setDrMsgCb(function (\RdKafka\Producer $producer, \RdKafka\Message $message) {
//    var_dump($producer, $message);
//    if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
//        var_dump($message);
//    }
//});
//$conf->setLoggerCb(function ($producer, $level, $fac, $buf) {
//    var_dump($producer, $level, $fac, $buf);
//});
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

$topic = $producer->newTopic('ffi'); //, $topicConf);
var_dump($topic);

$metadata = $producer->getMetadata(false, $topic, 1000);
var_dump($metadata->getOrigBrokerName());
var_dump($metadata->getOrigBrokerId());
var_dump($metadata->getBrokers());
var_dump($metadata->getTopics());

for ($i = 0; $i < 10000; $i++) {
    $payload = 'test-' . $i;
    echo sprintf('produce msg: %s', $payload) . PHP_EOL;
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload);
    $events = $producer->poll(1); // >1 = triggers log output
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
}

