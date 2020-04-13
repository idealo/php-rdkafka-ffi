<?php

declare(strict_types=1);

use RdKafka\FFI\Api;

require_once dirname(__DIR__) . '/vendor/autoload.php';

Api::init('1.0.0');

echo 'Binding Version (string): ' . Api::getVersion() . PHP_EOL;
echo 'Library Version (int)   : ' . Api::rd_kafka_version() . PHP_EOL;
echo 'Library Version (string): ' . FFI::string(Api::rd_kafka_version_str()) . PHP_EOL;
