<?php

declare(strict_types=1);

$ffiKafka = FFI::scope('RdKafka');

echo 'Version (int)   : ' . $ffiKafka->rd_kafka_version() . PHP_EOL;
echo 'Version (string): ' . $ffiKafka->rd_kafka_version_str() . PHP_EOL;
