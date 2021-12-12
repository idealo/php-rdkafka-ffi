# Topic Configuration

## Using your preferred framework

To get configuration options for a specific topic using your favorable PHP framework, you can use the following example:

### Configure Topic

#### Import the classes needed

```
use RdKafka\Admin\Client;
use RdKafka\Admin\ConfigResource;
use RdKafka\Conf;
```

#### Set the configuration options

```
$options['t'] = 2; // Type flag;
$options['v'] = 'playground'; // Our default topic name
$options['b'] = 'kafka:9092'; // Our default broker URL
```

#### Configure the topic

```
$conf = new Conf();
$conf->set('bootstrap.servers', $options['b'] ?? getenv('KAFKA_BROKERS') ?: 'kafka:9092');
$client = Client::fromConf($conf);
$client->setWaitForResultEventTimeout(2000);
```

#### Call the cluster

```
$results = $client->describeConfigs([
    new ConfigResource((int) $options['t'], (string) $options['v']),
]);
```

#### Fetch the configuration results

```
foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        // Play around with the configuration options using $result->configs array
    }
}
```

### Create topic

To create a topic, first we need to add some options like so:

#### Import needed classes

```
use RdKafka\Admin\Client;
use RdKafka\Admin\NewTopic;
use RdKafka\Conf;
```

#### Create topic options

```
$options['t'] = 'playground'; // A fake topic name
$options['b'] = 'kafka:9092'; // Default broker URL
$options['p'] = 1; // Default number of partitions
$options['r'] = 1; // Default replication factor
```

#### Configure the created topic

```
$conf = new Conf();
$conf->set('bootstrap.servers', $options['b'] ?? getenv('KAFKA_BROKERS') ?: 'kafka:9092');
$client = Client::fromConf($conf);
$client->setWaitForResultEventTimeout((int) $options['w'] ?? 10000);
$partitions = $options['p'] ?? 1;
$replicationFactor = $options['r'] ?? 1;
```

#### Fetch topic creation results

```
foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        // Handle success scenario
    } else {
        // Handle error scenario
    }
}
```

### Delete Topic

#### Import classes needee

```
use RdKafka\Admin\Client;
use RdKafka\Admin\DeleteTopic;
use RdKafka\Conf;
```

#### Delete topic options

```
$options['t'] = 'playground'; // Fake topic name
$options['b'] = 'kafka:9092'; // Default broker URL
$options['w'] = 10000; // Wait timeout for results
```

#### Configure topic

```
$conf = new Conf();
$conf->set('bootstrap.servers', $options['b'] ?? getenv('KAFKA_BROKERS') ?: 'kafka:9092');
$client = Client::fromConf($conf);
$client->setWaitForResultEventTimeout((int) $options['w'] ?? 10000);
```

#### Get deletion results

```
$results = $client->deleteTopics(
    [
        new DeleteTopic(
            (string) $options['t']
        ),
    ]
);
```

#### Fetch topic deletion results

```
foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        // Handle success results
    } else {
        // Handle deletion errors
    }
    echo PHP_EOL;
}
```

## Example

And if you want to get a specific topic's configuration options from scratch, you can use [this](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/describe-config.php) example instead.

And if you want to create a topic, you can use [this](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/create-topic.php) example instead.

Finally, if youw ant to delete a topic, you can use [this](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/delete-topic.php) example instead.


## Try Using CLI

Finally, if you want to get configuration options for a specific topic using the command line, use the following command:

1. Create a topic called "playground" as an example using the following command: ``` docker-compose run --rm php74 php examples/create-topic.php -tplayground -p3 -r1 ```

2. Get the topic's configuration options using the following command: ``` docker-compose run --rm php74 php examples/describe-config.php -t=2 -v=playground -b=kafka:9092 ```

The options -t is for the type of config you want and in our case it should be ``` 2 ``` to get configuration options for a specific topic.

The option -v which is the value of the topic name that you want to get its own configuration options and in our example we use ``` playground ```.

And the last option -b indicates the broker URL used in our example ``` kafka:9092 ```

Then you should see the configuration options for the topic you selected.

You can use the same methodology for creating and deleting a topic.
