<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$options = getopt('t:');
if (empty($options)) {
    echo sprintf(
        "Usage: %s -t{topicname}" . PHP_EOL,
        basename(__FILE__)
    );
    exit();
}

$conf = new \RdKafka\Conf();
$conf->set('metadata.broker.list', 'kafka:9092');
$client = \RdKafka\Admin\Client::fromConf($conf);

$result = $client->deleteTopics([
    new \RdKafka\Admin\DeleteTopic(
        (string) $options['t']
    ),
]);

var_dump($result);

