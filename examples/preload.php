<?php

declare(strict_types=1);

use RdKafka\Api;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$directory = new RecursiveDirectoryIterator(dirname(__DIR__) . '/src');
$iterator = new RecursiveIteratorIterator($directory);
$files = new RegexIterator($iterator, '/^.+\/[A-Z][^\/]+?\.php$/', RecursiveRegexIterator::GET_MATCH);

foreach ($files as $file) {
    \opcache_compile_file($file[0]);
}

Api::preload();
