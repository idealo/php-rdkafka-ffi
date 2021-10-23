<?php
/**
 * Do NOT use in production - play around against local dev kafka only.
 *
 * - Read consumer offsets from __consumer_offsets topic
 * - Query low/high topic watermarks
 * - Calculate offset lags
 *
 * You may run multiple high level consumers in parallel:
 *
 *      docker-compose run --rm php74 bash
 *      php examples/consumer-highlevel.php
 *
 * and produce messages with:
 *
 *      docker-compose run --rm php74 bash
 *      php examples/producer.php
 *
 * and get consumer offset status with:
 *
 *      docker-compose run --rm php74 bash
 *      php examples/offset-lags.php
 *
 * @todo handle tombstones & timestamps & active/inactive assignments correctly, in stream, improve protocol parsing ...
 */

declare(strict_types=1);

use Composer\Autoload\ClassLoader;
use RdKafka\Conf;
use RdKafka\Examples\Protocol\GroupMetadataValueParser;
use RdKafka\Examples\Protocol\MessageKeyParser;
use RdKafka\Examples\Protocol\OffsetCommitValueParser;
use RdKafka\KafkaConsumer;

/** @var ClassLoader $composerLoader */
$composerLoader = require_once dirname(__DIR__) . '/vendor/autoload.php';
$composerLoader->addPsr4('RdKafka\\Examples\\', __DIR__);

$conf = new Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('group.id', 'consumer-offsets.dev');
//$conf->set('log_level', (string)LOG_DEBUG);
//$conf->set('debug', 'all');
// do not commit when reading from __consumer_offsets
$conf->set('enable.auto.commit', 'false');
$conf->set('auto.offset.reset', 'earliest');
$conf->set('enable.partition.eof', 'true');
$conf->setLogCb(
    function ($consumer, $level, $fac, $buf): void {
        //echo "log: $level $fac $buf" . PHP_EOL;
    }
);
$consumer = new KafkaConsumer($conf);

// collect watermarks for all topics per topic & partition
$topicWatermarks = [];
$metadata = $consumer->getMetadata(true, null, 1000);
foreach ($metadata->getTopics() as $metadataTopic) {
    $partitions = $metadataTopic->getPartitions();
    foreach ($metadataTopic->getPartitions() as $metadataPartition) {
        $low = 0;
        $high = 0;
        $consumer->queryWatermarkOffsets($metadataTopic->getTopic(), $metadataPartition->getId(), $low, $high, 1000);
        $topicWatermarks[$metadataTopic->getTopic()][$metadataPartition->getId()] = [
            'low' => $low,
            'high' => $high,
        ];
    }
}
//var_export($topicWatermarks);

// collect consumer offsets per topic & partition
$consumer->subscribe(['__consumer_offsets']);

// read all messages
$eofs = [];
$compactedMessages = [];
do {
    $message = $consumer->consume(100);
    if ($message === null) {
        break;
    }
//    var_dump($message->key, $message->payload, $message->err);
    if ($message->err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
        echo '-';
        continue;
    }
    if ($message->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
        echo 'E';
        $eofs[$message->partition] = true;
        if (count($eofs) === 50) {
            break;
        }
//        var_export($eofs);
        continue;
    }


    // apply tombstones
    if ($message->payload === null) {
        echo '0';
        unset($compactedMessages[$message->key]);
        continue;
    }
    echo '.';
    $compactedMessages[$message->key] = $message->payload;
} while (true);
echo PHP_EOL . PHP_EOL;

$consumer->unsubscribe();

// prepare offset commit & group metadata values
$compactedOffsetCommitValues = [];
$compactedGroupMetadataValues = [];
foreach ($compactedMessages as $key => $payload) {
    // parse key value
    $keyParser = new MessageKeyParser($key);
    $keyParsed = $keyParser->getParsed();
//    var_dump($keyParser->getVersion());
//    var_export($keyParsed);

    switch ($keyParser->getVersion()) {
        case MessageKeyParser::V0_OFFSET_COMMIT_KEY:
        case MessageKeyParser::V1_OFFSET_COMMIT_KEY:
            $payloadParser = new OffsetCommitValueParser($payload);
            $parsed = $payloadParser->getParsed();
            $compactedOffsetCommitValues[$keyParsed['group']][$keyParsed['topic']][$keyParsed['partition']] = $parsed['offset'];
//            var_dump($payloadParser->getVersion());
//            var_export($parsed);
            break;
        case MessageKeyParser::V2_GROUP_METADATA_KEY:
            $payloadParser = new GroupMetadataValueParser($payload);
            $parsed = $payloadParser->getParsed();
//            var_dump($payloadParser->getVersion());
//            var_export($parsed);
            foreach ($parsed['members'] as $member) {
                foreach ($member['assignment']['topic_partitions'] as $topicPartition) {
                    foreach ($topicPartition['partitions'] as $partition) {
                        $compactedGroupMetadataValues[$keyParsed['group']][$topicPartition['topic']][$partition][$member['member_id']] = [
                            'client_id' => $member['client_id'],
                            'client_host' => $member['client_host'],
                        ];
                    }
                }
            }
            break;
    }
}

//var_export($compactedOffsetCommitValues);
//var_export($compactedGroupMetadataValues);

// lags
$offsetLagValues = [];
foreach ($compactedOffsetCommitValues as $group => $topics) {
    foreach ($topics as $topic => $partitions) {
        foreach ($partitions as $partition => $offset) {
            $offsetLagValues[$group][$topic][$partition] = [
                'offset' => $offset,
                'end' => $topicWatermarks[$topic][$partition]['high'],
                'lag' => $topicWatermarks[$topic][$partition]['high'] - $offset,
                'members' => $compactedGroupMetadataValues[$group][$topic][$partition] ?? [],
            ];
        }
    }
}

var_export($offsetLagValues);
