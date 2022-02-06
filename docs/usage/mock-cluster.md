# Mock Cluster

!!! Warning "Experimental"

    API can have breaking changes in next releases and does not follow semantic versioning.

!!! Tip

    Basic support is available since librdkafka 1.3. However it is recommended to use version 1.4 or higher to have better support for simulating error situations. 

Mock Cluster provides a simple and easy way for integration testing without the need to setup a real test kafka cluster e.g. via
docker-compose.

## Create cluster configuration

Configuration for the mock cluster is optional. You may disable logging output like this:

```php
$clusterConf = new \RdKafka\Conf();
$clusterConf->setLogCb(null);
```

## Create mock cluster

E.g. create 3 brokers with consecutive broker ids (1,2,3)

```php
$numberOfBrokers = 3;
$cluster = \RdKafka\Test\MockCluster::create($numberOfBrokers, $clusterConf);
```

## Produce and Consume Messages

E.g. produce message on partition 0

```php
$producerConf = new \RdKafka\Conf();
$producerConf->set('metadata.broker.list', $cluster->getBootstraps());
$producer = new \RdKafka\Producer($producerConf);
$topic = $producer->newTopic('playground');
$topic->produce(0, 0, 'any-payload');
$producer->flush(1000);
```

E.g. consume message on partition 0

```php
$consumerConf = new \RdKafka\Conf();
$consumerConf->set('group.id', 'mock-cluster-example');
$consumerConf->set('metadata.broker.list', $cluster->getBootstraps());
$consumer = new \RdKafka\KafkaConsumer($consumerConf);
$consumer->assign([new \RdKafka\TopicPartition('playground', 0, rd_kafka_offset_tail(1))]);
$message = $consumer->consume(1000)
```

## Create a specific test topic

!!! Note

    Admin protocol request types like creating or deleting a topic are not supported by the mock cluster.

E.g. create a topic with 3 partitions and replication factor 1

```php
$numberOfBrokers = 3;
$cluster = \RdKafka\Test\MockCluster::create($numberOfBrokers);

$cluster->createTopic('payload', 3, 1);
```

## Set broker up or down

```php
$numberOfBrokers = 2;
$cluster = \RdKafka\Test\MockCluster::create($numberOfBrokers);

// set broker with id 1 down
$cluster->setBrokerDown(1);

// set broker with id 1 up again
$cluster->setBrokerUp(1);
```

## Set broker as topic partition leader or follower

```php
$numberOfBrokers = 2;
$cluster = \RdKafka\Test\MockCluster::create($numberOfBrokers);
$cluster->createTopic('payload', 3, 1);

// set broker with id 1 as leader for topic payload partition 0
$cluster->setPartitionLeader('payload', 0, 1);

// set broker with id 2 as follower for topic payload partition 0
$cluster->setPartitionFollower('payload', 0, 2);
```

## Set coordinator for transactions

tbd.

## Prepare error situations

tbd.

## Run example

You can take a look at the [mock cluster example](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/mock-cluster.php) for an
actual implementation of the mocked cluster. Please take a look at how to [prepare](examples.md#prepare) running the examples before.

Run the example:

```bash
docker-compose run --rm php74 php examples/mock-cluster.php
```
