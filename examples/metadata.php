<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$conf = new \RdKafka\Conf();
$conf->set('group.id', 'metadata');
$conf->set('metadata.broker.list', 'kafka:9092');
//$conf->set('debug', 'all');
var_dump($conf->dump());

$producer = new \RdKafka\Producer($conf);

$metadata = $producer->getMetadata(true, null, 1000);
var_dump($metadata->getOrigBrokerName());
var_dump($metadata->getOrigBrokerId());
var_dump($metadata->getBrokers());
var_dump($metadata->getTopics());
