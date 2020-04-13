<?php

require __DIR__ . '/../../vendor/autoload.php';
require __DIR__ . '/config.php';

\RdKafka\FFI\Api::init(LIBRDKAFKA_VERSION);