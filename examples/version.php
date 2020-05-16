<?php

declare(strict_types=1);

use RdKafka\FFI\Library;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$version = getenv('LIBRDKAFKA_VERSION') ?: '';
$version = ltrim($version, 'v');
$version = $version === 'master' ? Library::VERSION_LATEST : $version;
Library::init($version);

echo 'Binding Version (string): ' . Library::getVersion() . PHP_EOL;
echo 'Library Version (int)   : ' . Library::rd_kafka_version() . PHP_EOL;
echo 'Library Version (string): ' . Library::rd_kafka_version_str() . PHP_EOL;
