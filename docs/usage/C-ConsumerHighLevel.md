# Create a High Level Consumer

## Using your preferred framework

To create a high level consumer using your favorable PHP framework, you can use the following example:

### Import the classes needed

```
use RdKafka\Conf;
use RdKafka\KafkaConsumer;
```

### Configure the consumer

```
$conf = new Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('group.id', 'consumer-highlevel');
$conf->set('enable.partition.eof', 'true');
$conf->set('auto.offset.reset', 'earliest');
$conf->set('log_level', (string) LOG_DEBUG);
$conf->set('debug', 'all');
$conf->setLogCb(
    function (KafkaConsumer $consumer, int $level, string $facility, string $message): void {
        // Perform your logging mechanism here
    }
);
```

### Create a consumer instance

```
$consumer = new KafkaConsumer($conf);
$consumer->subscribe(['playground']); // Our example topic name
```

### Start Consuming

```
do {
    $message = $consumer->consume(100);
    if ($message === null) {
        break;
    }

    // Process your message here

    if ($message->err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
        continue;
    }
    if ($message->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
        continue;
    }

    $consumer->commit($message);
} while (true);

```

## Example

And if you want to consume messages from scratch, you can use [this](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/consumer-highlevel.php) example instead.


## Try Using CLI

Finally, if you want to consume messages using the command line, use the following commands:

1. Create a topic called "playground" as an example using the following command: ``` docker-compose run --rm php74 php examples/create-topic.php -tplayground -p3 -r1 ```
2. Produce to the same topic that we created using the following command: ``` docker-compose run --rm php74 php examples/producer.php ```
3. Consume the messages produced to the same topic using the following command: ``` docker-compose run --rm php74 php examples/consumer-highlevel.php ```

And you should see the messages that we have produced to the topic "playground".
