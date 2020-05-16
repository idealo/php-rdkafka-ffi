<?php

declare(strict_types=1);

/**
 * Generate low level FFI bindings for multiple librdkafka stable version ^1.0.0
 *
 * (Windows is not supported)
 */

use Composer\Autoload\ClassLoader;
use RdKafka\FFIGen\MultiVersionGenerator;

/** @var ClassLoader $composerLoader */
$composerLoader = require_once dirname(__DIR__, 2) . '/vendor/autoload.php';
$composerLoader->addPsr4('RdKafka\\FFIGen\\', __DIR__);

$generator = new MultiVersionGenerator();
$generator->generate();