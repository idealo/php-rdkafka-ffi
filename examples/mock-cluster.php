<?php
/**
 * Experimental mock cluster support in librdkafka ^1.3.0
 * @see https://github.com/edenhill/librdkafka/blob/master/src/rdkafka_mock.h#L39
 */

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\KafkaConsumer;
use RdKafka\Producer;
use RdKafka\Test\MockCluster;
use RdKafka\TopicPartition;

require_once dirname(__DIR__) . '/vendor/autoload.php';

try {
    $cluster = MockCluster::create(3);
} catch (RuntimeException $exception) {
    echo $exception->getMessage() . PHP_EOL;
    exit();
}

// produce messages
$producerConf = new Conf();
$producerConf->set('metadata.broker.list', $cluster->getBootstraps());
$producerConf->set('log_level', (string) LOG_DEBUG);
$producerConf->set('debug', 'all');
$producerConf->setLogCb(
    function (Producer $rdkafka, int $level, string $fac, string $buf): void {
        echo sprintf('  log: %d %s %s', $level, $fac, $buf) . PHP_EOL;
    }
);

$producer = new Producer($producerConf);
$topic = $producer->newTopic('playground');
$topic->produce(RD_KAFKA_PARTITION_UA, 0, '');

for ($i = 0; $i < 1000; $i++) {
    $key = $i % 10;
    $payload = "payload-${i}-key-${key}";
    echo sprintf('produce msg: %s', $payload) . PHP_EOL;
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload, (string) $key);
    $events = $producer->poll(1); // triggers log output
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
}

// read metadata to topic partitions count
$metadata = $producer->getMetadata(false, $topic, 10000);
$partitions = $metadata->getTopics()->current()->getPartitions();

$producer->flush(1000);

// consume messages
$consumerConf = new Conf();
$consumerConf->set('group.id', 'mock-cluster-example');
$consumerConf->set('metadata.broker.list', $cluster->getBootstraps());
$consumerConf->set('log_level', (string) LOG_DEBUG);
$consumerConf->set('debug', 'all');
$consumerConf->set('enable.partition.eof', 'true');
$consumerConf->set('auto.offset.reset', 'earliest');
$consumerConf->setLogCb(
    function (KafkaConsumer $rdkafka, int $level, string $fac, string $buf): void {
        echo sprintf('  log: %d %s %s', $level, $fac, $buf) . PHP_EOL;
    }
);

$consumer = new KafkaConsumer($consumerConf);
$toppar = [];
foreach ($partitions as $partition) {
    $toppar[] = new TopicPartition('playground', $partition->getId());
}
$consumer->assign($toppar);

$eofPartitions = [];
while ($message = $consumer->consume(1000)) {
    if ($message->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
        $eofPartitions[$message->partition] = true;
        if (count($eofPartitions) === count($partitions)) {
            break;
        }
    }
    echo sprintf('consume msg: %s, ts: %s, p: %s', $message->payload, $message->timestamp, $message->partition) . PHP_EOL;
}
