<?php

$ffiKafka = \FFI::cdef("
    int rd_kafka_version(void);
    const char *rd_kafka_version_str (void);  
    ", "/usr/local/lib/librdkafka.so");

echo "Version (int)   : " . $ffiKafka->rd_kafka_version() . PHP_EOL;
echo "Version (string): " . $ffiKafka->rd_kafka_version_str() . PHP_EOL;
