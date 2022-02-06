# Admin Client

The admin client provides support for:

- reading/updating broker configuration
- creating/deleting topics
- reading/updating topic configuration
- deleting records from topics
- reading/updating consumer group configuration
- deleting consumer groups and consumer group offsets

Admin Client features depend on the currently very limited support in librdkafka.

!!! Warning "Experimental"

    API can have breaking changes in next releases and does not follow semantic versioning.

## Create client

There are 3 ways to create an Admin Client.

### From Conf

``` php
$config = new RdKafka\Conf();
$config->set('metadata.broker.list', 'kafka:9092');
$client = RdKafka\Admin\Client::fromConf($conf);
```

### From Producer

```php
// \RdKafka\Producer $producer was initialized before
$client = \RdKafka\Admin\Client::fromProducer($producer);
```

### From Consumer (low level)

```php
// \RdKafka\Consumer $consumer was initialized before
$client = \RdKafka\Admin\Client::fromConsumer($consumer);
```

You may optionally set internal waitForResultEventTimeout property in case you run into timing issues:

```php
$timeoutMs = 100;
$client->setWaitForResultEventTimeout($timeoutMs);
```

## Configuration

You can read or change config values on resource types Broker, Topic or Consumer Group.

### Resource Types

#### Topic

Initialize ConfigResource for a topic:

```php
$configResource = new \RdKafka\Admin\ConfigResource(
    RD_KAFKA_RESOURCE_TOPIC, // 2
    'test' // name of topic
);
```

#### Consumer Group

Initialize ConfigResource for a consumer group:

```php
$configResource = new \RdKafka\Admin\ConfigResource(
    RD_KAFKA_RESOURCE_GROUP, // 3
    'test' // name of consumer group
);
```

#### Broker

Initialize ConfigResource for a broker:

```php
$configResource = new \RdKafka\Admin\ConfigResource(
    RD_KAFKA_RESOURCE_BROKER, // 4
    '111' // broker id
);
```

#### Set Config Values

Set config values on resource for alterConfigs requests.

```php
$configResource->setConfig('max.connections.per.ip', (string) 2147483647);
$configResource->setConfig('any.other', 'new value');
```

### Describe

Read configurations for resources:

```php
// optionally set request options
$options = $client->newDescribeConfigsOptions();
$options->setRequestTimeout(500);
$options->setBrokerId(111);

$results = $client->describeConfigs(
    [
        new \RdKafka\Admin\ConfigResource(
            RD_KAFKA_RESOURCE_BROKER,
            '111'
        ),
        new \RdKafka\Admin\ConfigResource(
            RD_KAFKA_RESOURCE_TOPIC,
            'test'
        )
    ],
    $options
);

foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        var_dump($result->configs);
    } else {
        // handle errors
    }
}
```

`$results` contains array of `\RdKafka\Admin\ConfigResourceResult` objects for each requested ConfigResource.

### Alter

Change configuration values for resources:

```php
$configResource = new \RdKafka\Admin\ConfigResource(
    RD_KAFKA_RESOURCE_BROKER,
    '111' // broker id
);
$configResource->setConfig('max.connections.per.ip', '2147483647');

// optionally set request options
$options = $client->newDescribeConfigsOptions();
$options->setRequestTimeout(500);
$options->setBrokerId(111);

$results = $client->alterConfigs(
    [
        $configResource
    ],
    $options
);

foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        var_dump($result->configs);
    } else {
        // handle errors
    }
}
```

`$results` contains array of `\RdKafka\Admin\ConfigResourceResult` objects for each requested ConfigResource.

## Topic

### Create

```php
// optionally set request options
$options = $client->newCreateTopicsOptions();
$options->setRequestTimeout(500);
$options->setBrokerId(111);
$options->setValidateOnly(true); // set true for dry run

$results = $client->createTopics(
    [
        new \RdKafka\Admin\NewTopic(
            'test', // name of topic
            1, // partitions
            1 // replica
        ),
    ],
    $options
);

foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        var_dump($result->configs);
    } else {
        // handle errors
    }
}
```

`$results` contains array of `\RdKafka\Admin\TopicResult` objects for each requested NewTopic.

### Delete

```php
// optionally set request options
$options = $client->newDeleteTopicsOptions();
$options->setRequestTimeout(500);
$options->setBrokerId(111);
$options->setValidateOnly(true); // set true for dry run

$results = $client->deleteTopics(
    [
        new \RdKafka\Admin\DeleteTopic(
            'test', // name of topic
        ),
    ],
    $options
);

foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        var_dump($result->configs);
    } else {
        // handle errors
    }
}
```

`$results` contains array of `\RdKafka\Admin\TopicResult` objects for each requested DeleteTopic.

### Add Partitions

```php
// optionally set request options
$options = $client->newDeleteTopicsOptions();
$options->setRequestTimeout(500);
$options->setBrokerId(111);
$options->setValidateOnly(true); // set true for dry run

$results = $client->createPartitions(
    [
        new \RdKafka\Admin\NewPartitions(
            'test', // name of topic
            3, // new total partition count
        ),
    ],
    $options
);

foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        var_dump($result->configs);
    } else {
        // handle errors
    }
}
```

### Delete Records (Messages)

Delete records (messages) in topic partitions older than the offsets provided.

```php
// optionally set request options
$options = $client->newDeleteRecordsOptions();
$options->setRequestTimeout(500);
$options->setBrokerId(111);
$options->setValidateOnly(true); // set true for dry run

$results = $client->deleteRecords(
    [
        new \RdKafka\Admin\DeleteRecords(
            new \RdKafka\TopicPartition('example', 0, 1)
        ),
    ],
    $options
);

foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        var_dump($result);
    } else {
        // handle errors
    }
}
```

`$results` contains array of `\RdKafka\TopicPartition` objects for each requested TopicPartition.

## Consumer Group

### Delete Group

tbd.

### Delete Consumer Group Offsets

tbd.

## Get Metadata

Request Metadata for Broker, Topics and Partitions from broker cluster.

### For all topics

This will also return data for internal topics like `__consumer_offsets`.

```php
$metadata = $client->getMetadata(
    true, // true for all topics
    null,
    1000 // timeout in ms
);

var_dump($metadata->getOrigBrokerName());
var_dump($metadata->getOrigBrokerId());
var_dump($metadata->getBrokers());
var_dump($metadata->getTopics());
```

### For specific topic

```php
$metadata = $client->getMetadata(
    false, // false to request data only for specific topic
    $topic, // instance of a RdKafka\Topic
    1000 // timeout in ms
);

var_dump($metadata->getOrigBrokerName());
var_dump($metadata->getOrigBrokerId());
var_dump($metadata->getBrokers());
var_dump($metadata->getTopics()); // will hold only details to specific topic
```

## Run Examples

If you want to test some of the Admin Client features, you can take a look at the examples. Please take a look at how
to [prepare](examples.md#prepare) running the examples before.

### Describe config

Cli options of the [describe config example](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/describe-config.php)

- `-t` is for the type of config you want and in our case it should be `4` to get configuration options for a specific broker
- `-v` is the value of the broker ID that you want to get its own configuration options and in our example we use `111`
- `-b` is the broker used and in our example we use `kafka:9092`

Run the example:

```bash
docker-compose run --rm php74 php examples/describe-config.php -t=4 -v=111 -b=kafka:9092
```

And you should see the configuration options for the broker you selected.

### Create Topic

Cli options of the [create topic example](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/create-topic.php)

- `-t` is the name of the topic to be created and in our example we use `example`
- `-p` is the number of partitions and in our example we use `3`
- `-r` is the number of replicas and in our example we use `1`
- `-b` is the broker used and in our example we use `kafka:9092`
- `-w` is the time to wait for the result in ms `10000`

Run the example:

```bash
docker-compose run --rm php74 php examples/create-topic.php -t=example -p=3 -r=1 -b=kafka:9092
```

And you should see the topic `example`.

### Delete Topic

Cli options of the [delete topic example](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/create-topic.php)

- `-t` is the name of the topic to be deleted and in our example we use `example`
- `-b` is the broker used and in our example we use `kafka:9092`
- `-w` is the time to wait for the result in ms `10000`

Run the example:

```bash
docker-compose run --rm php74 php examples/delete-topic.php -t=example -b=kafka:9092
```

And you should not see topic `example` any longer.
