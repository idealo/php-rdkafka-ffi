<?php

declare(strict_types=1);

use RdKafka\Admin\Client;
use RdKafka\Admin\DeleteTopic;
use RdKafka\Conf;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$options = getopt('t:');
if (empty($options)) {
    echo sprintf(
        "Usage: %s -t{topicname}" . PHP_EOL,
        basename(__FILE__)
    );
    exit();
}

$conf = new Conf();
$conf->set('metadata.broker.list', 'kafka:9092');
$client = Client::fromConf($conf);

$result = $client->deleteTopics(
    [
        new DeleteTopic(
            (string)$options['t']
        ),
    ]
);

var_dump($result);

