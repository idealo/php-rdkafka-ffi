<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

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
//$conf->setDrMsgCb(function (\RdKafka\Producer $producer, \RdKafka\Message $message) {
//    var_dump($message);
//    if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
//        var_dump($message);
//    }
//});
$conf->setDefaultTopicConf($topicConf);
var_dump($conf->dump());


//pcntl_sigprocmask(SIG_BLOCK, [SIGIO]);
//$conf->set('internal.termination.signal', SIGIO);

$producer = new \RdKafka\Producer($conf);
$producer->setLogLevel(LOG_DEBUG);
$added = $producer->addBrokers('kafka:9092');
var_dump($added);

$topic = $producer->newTopic('ffi', $topicConf);
var_dump($topic);

for ($i = 0; $i < 10000; $i++) {
    usleep(2000);
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, 'test-' . $i);
}

