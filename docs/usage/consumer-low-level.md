# Create a Low Level Consumer

!!! Warning

    Consider using the low level consumer only if you need more flexible control over consuming messages.

## Configure the Consumer

```php
$conf = new \RdKafka\Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('group.id', 'test');
$conf->set('log_level', (string) LOG_DEBUG);
$conf->set('debug', 'all');
$conf->setLogCb(
    function (\RdKafka\Consumer $consumer, int $level, string $facility, string $message): void {
        // Perform your logging mechanism here
    }
);

$conf->set('statistics.interval.ms', (string) 1000);
$conf->setStatsCb(
    function (\RdKafka\Consumer $consumer, string $json, int $jsonLength, $opaque): void {
        // Perform your stats mechanism here ...
    }
);
```

See [configuration](configuration.md) for more details.

## Configure the topic

```php
$topicConf = new \RdKafka\TopicConf();
$topicConf->set('enable.auto.commit', 'true');
$topicConf->set('auto.commit.interval.ms', (string) 100);
$topicConf->set('auto.offset.reset', 'earliest');
```

## Create a consumer instance

```php
$consumer = new \RdKafka\Consumer($conf);
```

## Consume from topic

```php
$topic = $consumer->newTopic('playground', $topicConf); // Our example topic name
```

## Create a new Queue

```php
$queue = $consumer->newQueue();
```

## Consume Messages

E.g. consume messages from 3 partitions via the new queue

```php
$topic->consumeQueueStart(0, RD_KAFKA_OFFSET_BEGINNING, $queue);
$topic->consumeQueueStart(1, RD_KAFKA_OFFSET_BEGINNING, $queue);
$topic->consumeQueueStart(2, RD_KAFKA_OFFSET_BEGINNING, $queue);
do {
    $message = $queue->consume(1000);
    
    if ($message === null) {
        continue;
    } elseif ($message->err === RD_KAFKA_RESP_ERR_NO_ERROR) {
        // process your message here
    } elseif ($message->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
        // handle end of partition
    } elseif ($message->err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
        // handle timeout
    } else {
        // handle other errors
        $topic->consumeStop(0);
        $topic->consumeStop(1);
        $topic->consumeStop(2);
        throw new \Exception($message->errstr(), $message->err);
    }

    // trigger callback queues
    $consumer->poll(1);
} while (true);
```

## Finish the Consumption

```php
$topic->consumeStop(0);
$topic->consumeStop(1);
$topic->consumeStop(2);
```

## Run Example

If you want to test consuming messages with the high level consumer, you can take a look at
the [low level consumer example](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/consumer-lowlevel.php). Please take a look at
how to [prepare](examples.md#prepare) running the examples before.

Produce to the same topic that we created using the following command:

```bash
docker-compose run --rm php74 php examples/producer.php
```

Consume the messages produced to the same topic using the following command:

```bash
docker-compose run --rm php74 php examples/consumer-lowlevel.php
```

And you should see all messages consumed from topic `playground`.
