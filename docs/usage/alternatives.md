# Alternatives

## RdKafka Extension

The PHP Extension [rdkafka](https://pecl.php.net/package/rdkafka) ([github](https://github.com/arnaud-lb/php-rdkafka)) uses librdkafka for binding.
This is the best known Kafka client implementation for PHP. It is maintained by [Arnaud Le Blanc](https://github.com/arnaud-lb).

It currently does not support features like the Admin Client and Mock Cluster.

!!! NOTE
    
    The RdKafka FFI library supports the same interfaces like this extension.

## Simple Kafka Client Extension

The PHP Extension [simple_kafka_client](https://pecl.php.net/package/simple_kafka_client) ([github](https://github.com/php-kafka/php-simple-kafka-client)) uses librdkafka for binding.
This implementation focuses on simplicity. It is maintained by [Nikazu Tenaka](https://github.com/nick-zh).

More resources around PHP & Kafka can be found at https://github.com/php-kafka.