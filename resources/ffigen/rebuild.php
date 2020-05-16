<?php

declare(strict_types=1);

/**
 * Generate low level FFI bindings for multiple librdkafka stable version ^1.0.0
 *
 * (Windows is not supported)
 */

use RdKafka\FFIGen\MultiVersionGenerator;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$generator = new MultiVersionGenerator();
$generator->generate();
