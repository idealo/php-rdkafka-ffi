<?php

declare(strict_types=1);

use RdKafka\Admin\Client;
use RdKafka\Admin\DeleteTopic;
use RdKafka\Conf;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$options = array_merge(
    [
        'b' => getenv('KAFKA_BROKERS') ?: 'kafka:9092',
        'w' => 10000,
    ],
    getopt('t:b::w::')
);
if (empty($options['t'])) {
    echo sprintf(
        'Usage: %s -t{topicname} [-b{brokerList:kafka:9092} [-w{waitForResultMs:10000}]' . PHP_EOL,
        basename(__FILE__)
    );
    exit();
}

$conf = new Conf();
$conf->set('bootstrap.servers', $options['b']);
$client = Client::fromConf($conf);
$client->setWaitForResultEventTimeout((int) $options['w']);

$results = $client->deleteTopics(
    [
        new DeleteTopic(
            (string) $options['t']
        ),
    ]
);

foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        echo sprintf(
            'Deleted topic %s.',
            $result->name,
        );
    } else {
        echo sprintf(
            'Failed to delete topic %s. Reason: %s (%s)',
            $result->name,
            $result->errorString,
            $result->error
        );
    }
    echo PHP_EOL;
}
