# Topic Configuration

!!! Note

    See [librdkafka CONFIGURATION](https://github.com/edenhill/librdkafka/blob/master/CONFIGURATION.md) for topic specific parameters

## Set Partitioner

!!! Tip

    Default partitioner for librdkafka is `consistent_random` while for Java based tools like Kafka MirrorMaker 2 or Kafka Rest Api Proxy it is `murmur2_random`.

```php
$topicConf = new \RdKafka\TopicConf();
$topicConf->setPartitioner(RD_KAFKA_MSG_PARTITIONER_MURMUR2_RANDOM);
```

## Use a custom Partitioner

```php
$topicConf = new \RdKafka\TopicConf();
$topicConf->setPartitionerCb(
    function (string $key, int $partitionCount):int {
        // e.g. force partition 2
        return 2;
    }
);
```

