<?php

declare(strict_types=1);

use RdKafka\FFI\Library;

// use custom librdkafka library path
Library::init(
    Library::VERSION_AUTODETECT,
    'RdKafka',
    getenv('LIBRDKAFKA_LIBRARY_PATH') ?: null
);
