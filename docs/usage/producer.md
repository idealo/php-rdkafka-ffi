# Create a Producer

## Configure the producer

```php
$conf = new \RdKafka\Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('socket.timeout.ms', (string) 50);
$conf->set('queue.buffering.max.messages', (string) 1000);
$conf->set('max.in.flight.requests.per.connection', (string) 1);
$conf->setDrMsgCb(
    function (\RdKafka\Producer $producer, \RdKafka\Message $message): void {
        if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            // Perform your error handling here using $message->errstr()
        }
    }
);
$conf->set('log_level', (string) LOG_DEBUG);
$conf->set('debug', 'all');
$conf->setLogCb(
    function (\RdKafka\Producer $producer, int $level, string $facility, string $message): void {
        // Perform your logging mechanism here
    }
);
$conf->set('statistics.interval.ms', (string) 1000);
$conf->setStatsCb(
    function (\RdKafka\Producer $producer, string $json, int $json_len, $opaque): void {
        // Perform your stats mechanism here ...
    }
);
```

See [configuration](configuration.md) for more details.

## Configure the topic

```php
$topicConf = new \RdKafka\TopicConf();
$topicConf->set('message.timeout.ms', (string) 30000);
$topicConf->set('request.required.acks', (string) -1);
$topicConf->set('request.timeout.ms', (string) 5000);
```

## Create the producer

```php
$producer = new \RdKafka\Producer($conf);
```

## Create a new topic

```php
$topic = $producer->newTopic('playground', $topicConf);
```

## Produce Messages

```php
for ($i = 0; $i < 1000; $i++) {
    $key = $i % 10;
    $payload = sprintf('payload-%d-%s', $i, $key);
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload, (string) $key);
    
    // trigger callback queues
    $producer->poll(1);
}

$producer->flush(5000);
```

!!! Warning

    Always call `flush` after producing messages to not lose messages on shutdown that are still queued up within librdkafka memory and not yet delivered to a broker.

## Flush on shutdown

Best practise is to wrap the producer instance and call flush on destruction.

```php
class ExampleApp {
    private \RdKafka\Producer $producer;
    
    function __construct(\RdKafka\Conf $conf) {
        $this->producer = new \RdKafka\Producer($conf);
    }
    
    function __destruct() {
        $err = $this->producer->flush(10000);
        if ($err === RD_KAFKA_RESP_ERR__TIMED_OUT) {
            throw new \RuntimeException('Failed to flush producer. Messages might not have been delivered.');
        }
    }
}
```

!!! Hint

    Call `flush(-1)` to wait indefinitely until all messages are flushed.

## Run example

If you want to test producing messages, you can take a look at
the [producer example](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/producer.php). Please take a look at how
to [prepare](examples.md#prepare) running the examples before.

Run the example:

```bash
docker-compose run --rm php74 php examples/producer.php
```

And now you have produced messages to the topic `playground`.
