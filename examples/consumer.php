<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$conf = new \RdKafka\Conf();
$conf->set('group.id', 'test');

$conf->set('debug', 'all');
$conf->setLoggerCb(function ($consumer, $level, $fac, $buf) {
    echo "log: $level $fac $buf" . PHP_EOL;
});

$conf->set('statistics.interval.ms', 500);
$conf->setStatsCb(function ($consumer, $json, $json_len, $opaque) {
    echo "stats: $json" . PHP_EOL;
});

$topicConf = new \RdKafka\TopicConf();
$topicConf->set('enable.auto.commit', 'true');
$topicConf->set('auto.commit.interval.ms', (string)100);
$topicConf->set('auto.offset.reset', 'smallest');
var_dump($topicConf->dump());

$conf->setDefaultTopicConf($topicConf);

if (function_exists('pcntl_sigprocmask')) {
    pcntl_sigprocmask(SIG_BLOCK, [SIGIO]);
    $conf->set('internal.termination.signal', SIGIO);
} else {
    $conf->set('queue.buffering.max.ms', 1);
}
var_dump($conf->dump());

$consumer = new \RdKafka\Consumer($conf);
$consumer->setLogLevel(LOG_DEBUG);
$added = $consumer->addBrokers('kafka:9092');
var_dump($added);

$topic = $consumer->newTopic('playground'); //, $topicConf);
var_dump($topic);

$metadata = $consumer->getMetadata(false, $topic, 1000);
var_dump($metadata->getOrigBrokerName());
var_dump($metadata->getOrigBrokerId());
var_dump($metadata->getBrokers());
var_dump($metadata->getTopics());

$queue = $consumer->newQueue();
$topic->consumeQueueStart(0, RD_KAFKA_OFFSET_BEGINNING, $queue);
$topic->consumeQueueStart(1, RD_KAFKA_OFFSET_BEGINNING, $queue);
$topic->consumeQueueStart(2, RD_KAFKA_OFFSET_BEGINNING, $queue);
while ($message = $queue->consume(1000)) {
    echo sprintf('consume msg: %s, ts: %s', $message->payload, $message->timestamp) . PHP_EOL;
    $events = $consumer->poll(1); // triggers log output
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
}
$topic->consumeStop(0);
$topic->consumeStop(1);
$topic->consumeStop(2);

