<?php

declare(strict_types=1);

use RdKafka\FFI\Api;

require_once dirname(__DIR__) . '/vendor/autoload.php';

echo 'has method rd_kafka_conf_new:' . PHP_EOL;
var_dump(Api::hasMethod('rd_kafka_conf_new'));

echo 'conf:' . PHP_EOL;
$conf = Api::rd_kafka_conf_new();
var_dump($conf);

echo 'producer:' . PHP_EOL;
$producer = Api::rd_kafka_new(0, $conf, null, null);
var_dump($producer);
