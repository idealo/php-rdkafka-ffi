<?php
/**
 * Experimental mock cluster support in librdkafka ^1.3.0
 * @see https://github.com/edenhill/librdkafka/blob/master/src/rdkafka_mock.h#L39
 */

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\Producer;

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (version_compare(rd_kafka_version(), '1.3.0', '<')) {
    echo sprintf('Requires stable librdkafka ^1.3.0, currently running with %s', rd_kafka_version()) . PHP_EOL;
}

// produce messages
$producerConf = new Conf();
$producerConf->set('test.mock.num.brokers', '3');
$producerConf->set('log_level', (string)LOG_DEBUG);
$producerConf->set('debug', 'all');
$producerConf->setLogCb(
    function ($rdkafka, $level, $fac, $buf) {
        echo "log: $level $fac $buf" . PHP_EOL;
    }
);

$producer = new Producer($producerConf);
$topic = $producer->newTopic('playground');
$topic->produce(RD_KAFKA_PARTITION_UA, 0, '');

for ($i = 0; $i < 1000; $i++) {
    $key = $i % 10;
    $payload = "payload-$i-key-$key";
    echo sprintf('produce msg: %s', $payload) . PHP_EOL;
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload, (string)$key);
    $events = $producer->poll(1); // triggers log output
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
}

// read metadata to extract broker list & topic partitions count
$metadata = $producer->getMetadata(true, null, 10000);
//var_export($metadata->getBrokers());
//var_export($metadata->getTopics());
$brokerList = [];
foreach ($metadata->getBrokers() as $broker) {
    $brokerList[] = $broker->getHost() . ':' . $broker->getPort();
}
$partitions = $metadata->getTopics()->current()->getPartitions();

// consume messages
$consumerConf = new Conf();
$consumerConf->set('metadata.broker.list', implode(',', $brokerList));
$consumerConf->set('log_level', (string)LOG_DEBUG);
$consumerConf->set('debug', 'all');
$consumerConf->set('enable.partition.eof', 'true');
$consumerConf->set('auto.offset.reset', 'earliest');
$consumerConf->setLogCb(
    function ($rdkafka, $level, $fac, $buf) {
        echo "log: $level $fac $buf" . PHP_EOL;
    }
);

$consumer = new Consumer($consumerConf);
$topic = $consumer->newTopic('playground');
$queue = $consumer->newQueue();
foreach ($partitions as $partition) {
    $topic->consumeQueueStart($partition->getId(), 0, $queue);
}
while ($message = $queue->consume(1000)) {
    echo sprintf('consume msg: %s, ts: %s', $message->payload, $message->timestamp) . PHP_EOL;
    $events = $consumer->poll(1); // triggers log output
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
}
foreach ($partitions as $partition) {
    $topic->consumeStop($partition->getId());
}
