<?php

declare(strict_types=1);

use RdKafka\Admin\Client;
use RdKafka\Admin\NewTopic;
use RdKafka\Conf;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$options = getopt('t:p::r::b::');
if (empty($options)) {
    echo sprintf(
        'Usage: %s -t{topicname} [-p{numberOfPartitions:1}] [-r{replicationFactor:1} [-b{brokerList:kafka:9092}]' . PHP_EOL,
        basename(__FILE__)
    );
    exit();
}

$conf = new Conf();
$conf->set('bootstrap.servers', $options['b'] ?? getenv('KAFKA_BROKERS') ?: 'kafka:9092');
$client = Client::fromConf($conf);
$client->setWaitForResultEventTimeout(2000);

$result = $client->createTopics(
    [
        new NewTopic(
            (string) $options['t'],
            (int) $options['p'] ?? 1,
            (int) $options['r'] ?? 1
        ),
    ]
);

var_dump($result);
