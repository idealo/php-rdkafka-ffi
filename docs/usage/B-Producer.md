# Create a Producer

## Using your preferred framework

To create a producer using your favorable PHP framework, you can use the following example:

### Import the classes needed

```
use RdKafka\Conf;
use RdKafka\Message;
use RdKafka\Producer;
use RdKafka\TopicConf;
```

### Configure the producer

```
$conf = new Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('socket.timeout.ms', (string) 50);
$conf->set('queue.buffering.max.messages', (string) 1000);
$conf->set('max.in.flight.requests.per.connection', (string) 1);
$conf->setDrMsgCb(
    function (Producer $producer, Message $message): void {
        if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            // Perform your error handling here using $message->errstr()
        }
    }
);
$conf->set('log_level', (string) LOG_DEBUG);
$conf->set('debug', 'all');
$conf->setLogCb(
    function (Producer $producer, int $level, string $facility, string $message): void {
        // Perform your logging mechanism here
    }
);
$conf->set('statistics.interval.ms', (string) 1000);
$conf->setStatsCb(
    function (Producer $producer, string $json, int $json_len, $opaque): void {
        // Perform your stats mechanism here ...
    }
);
```

### Configure the topic

```
$topicConf = new TopicConf();
$topicConf->set('message.timeout.ms', (string) 30000);
$topicConf->set('request.required.acks', (string) -1);
$topicConf->set('request.timeout.ms', (string) 5000);
```

### Create the producer

```
$producer = new Producer($conf);
```

### Create a new topic

```
$topic = $producer->newTopic('playground', $topicConf);

$metadata = $producer->getMetadata(false, $topic, 1000);
```

### Produce Messages

```
for ($i = 0; $i < 1000; $i++) {
    $key = $i % 10;
    $payload = sprintf('payload-%d-%s', $i, $key);
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload, (string) $key);
    $events = $producer->poll(1);
}

$producer->flush(5000);
```

## Example

And if you want to produce messages from scratch, you can use [this](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/producer.php) example instead.


## Try Using CLI

Finally, if you want to produce messages using the command line, use the following commands:

1. Create a topic called "playground" as an example using the following command: ``` docker-compose run --rm php74 php examples/create-topic.php -tplayground -p3 -r1 ```
2. Produce to the same topic that we created using the following command: ``` docker-compose run --rm php74 php examples/producer.php ```

And now you have produced messages to the topic "playground".
