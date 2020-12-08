<?php

declare(strict_types=1);

use RdKafka\Conf;
use RdKafka\Producer;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$conf = new Conf();
$conf->set('group.id', 'metadata');
$conf->set('bootstrap.servers', getenv('KAFKA_BROKERS') ?: 'kafka:9092');

$producer = new Producer($conf);

$metadata = $producer->getMetadata(true, null, 1000);
var_dump($metadata->getOrigBrokerName());
var_dump($metadata->getOrigBrokerId());
var_dump($metadata->getBrokers());
var_dump($metadata->getTopics());
