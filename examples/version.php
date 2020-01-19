<?php

declare(strict_types=1);

switch (PHP_OS_FAMILY) {
    case 'Darwin':
        $library = 'librdkafka.dylib';
        break;
    case 'Windows':
        $library = 'librdkafka.dll';
        break;
    default:
        $library = 'librdkafka.so';
        break;
}

$ffiKafka = \FFI::cdef(
    '
    int rd_kafka_version(void);
    const char *rd_kafka_version_str (void);  
    ',
    $library
);

echo 'Version (int)   : ' . $ffiKafka->rd_kafka_version() . PHP_EOL;
echo 'Version (string): ' . $ffiKafka->rd_kafka_version_str() . PHP_EOL;
