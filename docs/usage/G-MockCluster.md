# Mock Cluster (Testing)

## Import classes

To create a mocked cluster we will start by importing our classes as follows:

```
use RdKafka\Conf;
use RdKafka\KafkaConsumer;
use RdKafka\Producer;
use RdKafka\Test\MockCluster;
use RdKafka\TopicPartition;

```

## Set cluster configuration

Then we need to create our cluster configuration as follows:

```
$clusterConf = new Conf();
$clusterConf->set('log_level', (string) LOG_DEBUG);
$clusterConf->set('debug', 'all');
$clusterConf->setLogCb(
    function (RdKafka $rdkafka, int $level, string $facility, string $message): void {
        // Perform your logging logic here
    }
);
```

## Create mocked cluster instance

After that, we need to create our mocked cluster instance as follows:

```
try {
    $cluster = MockCluster::create(3, $clusterConf);
} catch (RuntimeException $exception) {
    // Handle error exception here
}
```

## Configure the producer

Comes next, our producer configuration as follows:

```
$producerConf = new Conf();
$producerConf->set('bootstrap.servers', $cluster->getBootstraps());
$producerConf->set('log_level', (string) LOG_DEBUG);
$producerConf->set('debug', 'all');
$producerConf->setLogCb(
    function (Producer $rdkafka, int $level, string $facility, string $message): void {
        // Perform your logging logic here
    }
);
```

## Create producer

And then, we create our producer as follows:

```
$producer = new Producer($producerConf);
$topic = $producer->newTopic('playground'); // Our default topic
$topic->produce(RD_KAFKA_PARTITION_UA, 0, '');
```

## Produce messages

Then, we have to produce some messages so we can consume as follows:

```
for ($i = 0; $i < 1000; $i++) {
    $key = $i % 10;
    $payload = "payload-${i}-key-${key}";
    $topic->produce(RD_KAFKA_PARTITION_UA, 0, $payload, (string) $key);
    $events = $producer->poll(1);
}
```

And we make sure that the producer has totally published the messages as follows:

```
$metadata = $producer->getMetadata(false, $topic, 10000);
$partitions = $metadata->getTopics()->current()->getPartitions();

$producer->flush(1000);
```

## Configure consumer

And next, we configure our consumer to prepare for message consumption as follows:

```
$consumerConf = new Conf();
$consumerConf->set('group.id', 'mock-cluster-example');
$consumerConf->set('bootstrap.servers', $cluster->getBootstraps());
$consumerConf->set('enable.partition.eof', 'true');
$consumerConf->set('auto.offset.reset', 'earliest');
$consumerConf->set('log_level', (string) LOG_DEBUG);
$consumerConf->set('debug', 'all');
$consumerConf->setLogCb(
    function (KafkaConsumer $rdkafka, int $level, string $facility, string $message): void {
        // Perform your logging logic here
    }
);
```

## Create consumer

Using the previous configuration, we have to create our consumer to start consuming messages as follows:

```
$consumer = new KafkaConsumer($consumerConf);
$toppar = [];
foreach ($partitions as $partition) {
    $toppar[] = new TopicPartition('playground', $partition->getId());
}
$consumer->assign($toppar);
```

## Start consuming

Then, we start consuming messages like so:

```
$eofPartitions = [];
do {
    $message = $consumer->consume(1000);
    if ($message === null) {
        break;
    }

    if ($message->err === RD_KAFKA_RESP_ERR__PARTITION_EOF) {
        $eofPartitions[$message->partition] = true;
        if (count($eofPartitions) === count($partitions)) {
            break;
        }
    }
    // Perform your logic here on the message using properties like payload, timestamp and partition.
} while (true);
```

## Example

Please, take a look a [this](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/mock-cluster.php) example for an actual implementation of the mocked cluster.

This way, you have worked with a mocked cluster and it is mainly used for testing purposes.
