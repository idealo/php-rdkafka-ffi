# Create a High Level Consumer

!!! Tip

    Consider using the high-level consumer if you want to worry less about managing offsets, handling broker failover and load balancing partitions and consumers.

### Configure the consumer

```php
$conf = new \RdKafka\Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('group.id', 'consumer-highlevel');
$conf->set('enable.partition.eof', 'true');
$conf->set('auto.offset.reset', 'earliest');
$conf->set('log_level', (string) LOG_DEBUG);
$conf->set('debug', 'all');
$conf->setLogCb(
    function (\RdKafka\KafkaConsumer $consumer, int $level, string $facility, string $message): void {
        // Perform your logging mechanism here
    }
);
```

See [configuration](configuration.md) for more details.

### Create a consumer instance

```php
$consumer = new \RdKafka\KafkaConsumer($conf);
$consumer->subscribe(['playground']); // Our example topic name
```

### Consume Messages

```php
do {
    $message = $consumer->consume(100);
 
    if ($message->err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
        continue;
    }
    if ($message->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
        continue;
    }
    
    // process your message here

    $consumer->commit($message);
} while (true);
```

## Run Example

If you want to test consuming messages with the high level consumer, you can take a look at
the [high level consumer example](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/consumer-highlevel.php). Please take a look
at how to [prepare](examples.md#prepare) running the examples before.

Produce to the same topic that we created using the following command:

```bash
docker-compose run --rm php74 php examples/producer.php
```

Consume the messages produced to the same topic using the following command:

```bash
docker-compose run --rm php74 php examples/consumer-highlevel.php
```

And you should see all messages consumed from topic `playground`.
