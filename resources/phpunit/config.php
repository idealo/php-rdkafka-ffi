<?php

define('KAFKA_BROKERS', getenv('KAFKA_BROKERS') ?: 'kafka:9092');
const KAFKA_TEST_TOPIC = "test";
const KAFKA_TEST_TOPIC_ADMIN = "test_admin";
const KAFKA_TEST_TOPIC_PARTITIONS = "test_partitions";
const KAFKA_TEST_TIMEOUT_MS = 20000;
const KAFKA_BROKER_ID = 111;
