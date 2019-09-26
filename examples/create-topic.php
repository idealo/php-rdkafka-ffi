<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$options = getopt('t:p::r::');
if (empty($options)) {
    echo sprintf(
        "Usage: %s -t{topicname} [-p{numberOfPartitions:1}] [-r{replicationFactor:1}]" . PHP_EOL,
        basename(__FILE__)
    );
    exit();
}

$conf = new \RdKafka\Conf();
$conf->set('metadata.broker.list', 'kafka:9092');
$client = \RdKafka\Admin\Client::fromConf($conf);

$result = $client->createTopics([
    new \RdKafka\Admin\NewTopic(
        (string)$options['t'],
        ((int)$options['p']) ?: 1,
        ((int)$options['r']) ?: 1
    ),
]);

var_dump($result);

