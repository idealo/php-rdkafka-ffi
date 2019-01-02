<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$topicConf = new \RdKafka\TopicConf();
$topicConf->set('auto.commit.interval.ms', 100);
$topicConf->set('auto.offset.reset', 'smallest');
var_dump($topicConf->dump());

$conf = new \RdKafka\Conf();
$conf->set('group.id', 'test');
var_dump($conf->dump());

//$conf->setDrMsgCb(function (\RdKafka\Producer $producer, \RdKafka\Message $message) {
//    if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
//        echo  $message->errstr() . PHP_EOL;
//    }
//});

//pcntl_sigprocmask(SIG_BLOCK, [SIGIO]);
//$conf->set('internal.termination.signal', SIGIO);

$consumer = new \RdKafka\Consumer($conf);
$consumer->setLogLevel(LOG_DEBUG);
$added = $consumer->addBrokers('kafka:9092');
var_dump($added);

$topic = $consumer->newTopic('ffi', $topicConf);
var_dump($topic);

$topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
do {
    $message = $topic->consume(0, 1000);
    if ($message === null) {
        usleep(10000);
    }
    var_dump($message);
} while ($message !== null);
$topic->consumeStop(0);

