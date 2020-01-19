<?php

declare(strict_types=1);

use RdKafka\FFI\Api;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$ffi = Api::getFFI();

echo 'conf:' . PHP_EOL;
$conf = $ffi->rd_kafka_conf_new();
var_dump($conf);

echo 'producer:' . PHP_EOL;
$producer = $ffi->rd_kafka_new(0, $conf, 'err', 3);
var_dump($producer);
