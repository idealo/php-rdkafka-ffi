<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$topicConf = new \RdKafka\TopicConf();
$topicConf->set('auto.commit.interval.ms', 100);
$topicConf->set('auto.offset.reset', 'smallest');
var_dump($topicConf->dump());

$conf = new \RdKafka\Conf();
$conf->set('group.id', 'test');
$conf->set('debug', 'all');
var_dump($conf->dump());

//pcntl_sigprocmask(SIG_BLOCK, [SIGIO]);
//$conf->set('internal.termination.signal', SIGIO);

$consumer = new \RdKafka\Consumer($conf);
$consumer->setLogLevel(LOG_DEBUG);
$added = $consumer->addBrokers('kafka:9092');
var_dump($added);

$topic = $consumer->newTopic('ffi', $topicConf);
var_dump($topic);

$topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
while ($message = $topic->consume(0, 1000)) {
    echo sprintf('consume msg: %s, ts: %s', $message->payload, $message->timestamp) . PHP_EOL;
    $events = $consumer->poll(1); // >1 = triggers log output
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
}
$topic->consumeStop(0);

