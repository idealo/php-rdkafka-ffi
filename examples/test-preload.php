<?php

declare(strict_types=1);

$ffiKafka = FFI::scope('RdKafka');

echo 'librdkafka version (int)   : ' . $ffiKafka->rd_kafka_version() . PHP_EOL;
echo 'librdkafka version (string): ' . $ffiKafka->rd_kafka_version_str() . PHP_EOL;

var_dump(\opcache_get_status(false));
