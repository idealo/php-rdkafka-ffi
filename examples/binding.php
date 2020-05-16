<?php

declare(strict_types=1);

use RdKafka\FFI\Library;

require_once dirname(__DIR__) . '/vendor/autoload.php';

echo 'has method rd_kafka_conf_new:' . PHP_EOL;
var_dump(Library::hasMethod('rd_kafka_conf_new'));

echo 'conf:' . PHP_EOL;
$conf = Library::rd_kafka_conf_new();
var_dump($conf);

echo 'producer:' . PHP_EOL;
$producer = Library::rd_kafka_new(0, $conf, null, null);
var_dump($producer);
