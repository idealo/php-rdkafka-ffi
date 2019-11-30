<?php

declare(strict_types=1);

$librdkafka = \FFI::load(dirname(__DIR__) . '/resources/rdkafka.h');

echo "conf:" . PHP_EOL;
$conf = $librdkafka->rd_kafka_conf_new();
var_dump($conf);

echo "producer:" . PHP_EOL;
$producer = $librdkafka->rd_kafka_new(0, $conf, 'err', 3);
var_dump($producer);

