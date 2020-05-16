<?php

use RdKafka\FFI\Library;

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/config.php';

$version = getenv('LIBRDKAFKA_VERSION') ?: '';
$version = ltrim($version, 'v');
$version = $version === 'master' ? Library::VERSION_LATEST : $version;
Library::init($version);
