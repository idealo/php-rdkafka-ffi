# Create a Low Level Consumer

## Using your preferred framework

To create a low level consumer using your favorable PHP framework, you can use the following example:

### Import the classes needed

```
use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\TopicConf;
```

### Configure the Consumer

```
$conf = new Conf();
$conf->set('bootstrap.servers', 'kafka:9092');
$conf->set('group.id', 'test');
$conf->set('log_level', (string) LOG_DEBUG);
$conf->set('debug', 'all');
$conf->setLogCb(
    function (Consumer $consumer, int $level, string $facility, string $message): void {
        // Perform your logging mechanism here
    }
);

$conf->set('statistics.interval.ms', (string) 1000);
$conf->setStatsCb(
    function (Consumer $consumer, string $json, int $jsonLength, $opaque): void {
        // Perform your stats mechanism here ...
    }
);
```

### Configure the topic

```
$topicConf = new TopicConf();
$topicConf->set('enable.auto.commit', 'true');
$topicConf->set('auto.commit.interval.ms', (string) 100);
$topicConf->set('auto.offset.reset', 'earliest');
```

### Create a consumer instance

```
$consumer = new Consumer($conf);
```

### Create a new Topic

```
$topic = $consumer->newTopic('playground', $topicConf); // Our example topic name
```

### Create a new Queue

```
$queue = $consumer->newQueue();
```

### Start your consumption

```
$topic->consumeQueueStart(0, RD_KAFKA_OFFSET_BEGINNING, $queue);
$topic->consumeQueueStart(1, RD_KAFKA_OFFSET_BEGINNING, $queue);
$topic->consumeQueueStart(2, RD_KAFKA_OFFSET_BEGINNING, $queue);
do {
    $message = $queue->consume(1000);
    if ($message === null) {
        break;
    }
    // Process your message here
} while (true);
```

### Finish the Consumption

```
$topic->consumeStop(0);
$topic->consumeStop(1);
$topic->consumeStop(2);
```

## Example

And if you want to consume messages from scratch, you can use [this](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/consumer.php) example instead.

## Try Using CLI

Finally, if you want to consume messages using the command line, use the following commands:

1. Create a topic called "playground" as an example using the following command: ``` docker-compose run --rm php74 php examples/create-topic.php -tplayground -p3 -r1 ```
2. Produce to the same topic that we created using the following command: ``` docker-compose run --rm php74 php examples/producer.php ```
3. Consume the messages produced to the same topic using the following command: ``` docker-compose run --rm php74 php examples/consumer.php ```

And you should see the messages that we have produced to the topic "playground".
