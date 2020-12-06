<?php

declare(strict_types=1);

use RdKafka\FFI\Library;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$version = getenv('LIBRDKAFKA_VERSION') ?: '';
$version = ltrim($version, 'v');
$version = $version === 'master' ? Library::VERSION_LATEST : $version;
Library::init($version);

echo 'Binding version (string)    : ' . Library::getVersion() . PHP_EOL;
echo 'librdkafka version (int)    : ' . Library::rd_kafka_version() . PHP_EOL;
echo 'librdkafka version (const)  : ' . RD_KAFKA_VERSION . PHP_EOL;
echo 'librdkafka version (string) : ' . Library::getLibraryVersion() . PHP_EOL;
echo 'PHP Library version (string): ' . Library::PHP_LIBRARY_VERSION . PHP_EOL;
echo 'Client version (string)     : ' . Library::getClientVersion() . PHP_EOL;
