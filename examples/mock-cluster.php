<?php
/**
 * Experimental mock cluster support in librdkafka ^1.3.0
 * @see https://github.com/confluentinc/librdkafka/blob/master/src/rdkafka_mock.h#L44
 */

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\KafkaConsumer;
use RdKafka\Producer;
use RdKafka\Test\MockCluster;
use RdKafka\TopicPartition;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$clusterConf = new Conf();
$clusterConf->set('log_level', (string) LOG_DEBUG);
$clusterConf->set('debug', 'all');
$clusterConf->setLogCb(
    function (RdKafka $rdkafka, int $level, string $facility, string $message): void {
        echo sprintf('  log-cluster: %d %s %s', $level, $facility, $message) . PHP_EOL;
    }
);
try {
    $cluster = MockCluster::create(3, $clusterConf);
} catch (RuntimeException $exception) {
    echo $exception->getMessage() . PHP_EOL;
    exit();
}

// produce messages
$producerConf = new Conf();
$producerConf->set('bootstrap.servers', $cluster->getBootstraps());
$producerConf->set('log_level', (string) LOG_DEBUG);
$producerConf->set('debug', 'all');
$producerConf->setLogCb(
    function (Producer $rdkafka, int $level, string $facility, string $message): void {
        echo sprintf('  log-produce: %d %s %s', $level, $facility, $message) . PHP_EOL;
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
    // triggers log output
    $events = $producer->poll(1);
    echo sprintf('polling triggered %d events', $events) . PHP_EOL;
}

// read metadata to topic partitions count
$metadata = $producer->getMetadata(false, $topic, 10000);
$partitions = $metadata->getTopics()->current()->getPartitions();

$producer->flush(1000);

// consume messages
$consumerConf = new Conf();
$consumerConf->set('group.id', 'mock-cluster-example');
$consumerConf->set('bootstrap.servers', $cluster->getBootstraps());
$consumerConf->set('enable.partition.eof', 'true');
$consumerConf->set('auto.offset.reset', 'earliest');
$consumerConf->set('log_level', (string) LOG_DEBUG);
$consumerConf->set('debug', 'all');
$consumerConf->setLogCb(
    function (KafkaConsumer $rdkafka, int $level, string $facility, string $message): void {
        echo sprintf('  log-consume: %d %s %s', $level, $facility, $message) . PHP_EOL;
    }
);

$consumer = new KafkaConsumer($consumerConf);
$toppar = [];
foreach ($partitions as $partition) {
    $toppar[] = new TopicPartition('playground', $partition->getId());
}
$consumer->assign($toppar);

$eofPartitions = [];
do {
    $message = $consumer->consume(1000);
    if ($message === null) {
        break;
    }

    if ($message->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
        $eofPartitions[$message->partition] = true;
        if (count($eofPartitions) === count($partitions)) {
            break;
        }
    }
    echo sprintf('consume msg: %s, ts: %s, p: %s', $message->payload, $message->timestamp, $message->partition) . PHP_EOL;
} while (true);
