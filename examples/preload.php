<?php

declare(strict_types=1);

use RdKafka\FFI\Library;

require_once dirname(__DIR__) . '/vendor/autoload.php';
include '_init.php';

$files = new RegexIterator(
    new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(
            dirname(__DIR__) . '/src'
        )
    ),
    '/^.+\/[A-Z][^\/]+?\.php$/'
);

foreach ($files as $file) {
    if ($file->isFile() === false) {
        continue;
    }
    require_once($file->getPathName());
}

Library::preload(
    Library::VERSION_AUTODETECT,
    'RdKafka',
    getenv('LIBRDKAFKA_LIBRARY_PATH') ?? null
);
