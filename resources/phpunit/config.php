<?php

define('LIBRDKAFKA_LIBRARY_PATH', getenv('LIBRDKAFKA_LIBRARY_PATH') ?: null);
define('KAFKA_BROKERS', getenv('KAFKA_BROKERS') ?: 'kafka:9092');
const KAFKA_TEST_TOPIC = "test";
const KAFKA_TEST_TOPIC_ADMIN = "test_admin";
const KAFKA_TEST_TOPIC_PARTITIONS = "test_partitions";
const KAFKA_TEST_LONG_TIMEOUT_MS = 10000;
const KAFKA_TEST_SHORT_TIMEOUT_MS = 100;
const KAFKA_BROKER_ID = 111;
