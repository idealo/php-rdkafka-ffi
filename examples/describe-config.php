<?php

declare(strict_types=1);

use RdKafka\Admin\Client;
use RdKafka\Admin\ConfigResource;
use RdKafka\Conf;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$options = array_merge(
    [
        'b' => getenv('KAFKA_BROKERS') ?: 'kafka:9092',
    ],
    getopt('t:v:b::')
);
if (empty($options['t']) || empty($options['v'])) {
    echo sprintf(
        'Usage: %s -t{resourceType} -v{resourceValue} [-b{brokerList:kafka:9092}]' . PHP_EOL . PHP_EOL .
        '   topic : -t2 -v{nameOfTopic:test}' . PHP_EOL .
        '   broker: -t4 -v{idOfBroker:111}' . PHP_EOL . PHP_EOL,
        basename(__FILE__)
    );
    exit();
}

$conf = new Conf();
$conf->set('bootstrap.servers', $options['b']);
$client = Client::fromConf($conf);
$client->setWaitForResultEventTimeout(2000);

$results = $client->describeConfigs(
    [
        new ConfigResource((int) $options['t'], (string) $options['v']),
    ]
);

foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        var_dump($result->configs);
    }
}
