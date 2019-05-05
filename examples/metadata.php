<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

$conf = new \RdKafka\Conf();
$conf->set('group.id', 'metadata');
$conf->set('debug', 'all');
var_dump($conf->dump());

$consumer = new \RdKafka\Consumer($conf);
$consumer->setLogLevel(LOG_DEBUG);
$added = $consumer->addBrokers('kafka:9092');
var_dump($added);

$metadata = $consumer->getMetadata(true, null, 1000);
var_dump($metadata->getOrigBrokerName());
var_dump($metadata->getOrigBrokerId());
var_dump($metadata->getBrokers());
var_dump($metadata->getTopics());