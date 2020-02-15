<?php

if (PHP_OS_FAMILY === 'Windows') {
    define('KAFKA_BROKERS', 'localhost:9092');
} else {
    define('KAFKA_BROKERS', 'kafka:9092');
}
const KAFKA_TEST_TOPIC = "test";
const KAFKA_TEST_TOPIC_PARTITIONS = "test_partitions";
const KAFKA_TEST_TIMEOUT_MS = 6000;
const KAFKA_BROKER_ID = 111;
