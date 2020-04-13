<?php

use RdKafka\FFI\Api;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/config.php';

$version = getenv('LIBRDKAFKA_VERSION') ?: '';
$version = ltrim($version, 'v');
$version = $version === 'master' ? Api::VERSION_LATEST : $version;
Api::init($version);
