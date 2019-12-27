<?php

declare(strict_types=1);

$ffiKafka = FFI::cdef(
    "
    int rd_kafka_version(void);
    const char *rd_kafka_version_str (void);  
    ",
    "librdkafka.so"
);

echo "Version (int)   : " . $ffiKafka->rd_kafka_version() . PHP_EOL;
echo "Version (string): " . $ffiKafka->rd_kafka_version_str() . PHP_EOL;
