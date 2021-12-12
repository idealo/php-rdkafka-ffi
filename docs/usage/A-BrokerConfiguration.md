# Broker Configuration

## Using your preferred framework

To get configuration options for a specific broder using your favorable PHP framework, you can use the following example:

### Import classes

```
use RdKafka\Admin\Client;
use RdKafka\Admin\ConfigResource;
use RdKafka\Conf;
```

### Add parameters

```
$options['t'] = 4; // Type flag;
$options['v'] = 111; // Our default broker ID
$options['b'] = 'kafka:9092'; // Our default broker URL
```

### Configure the cluster

```
$conf = new Conf();
$conf->set('bootstrap.servers', $options['b'] ?? getenv('KAFKA_BROKERS') ?: 'kafka:9092');
```

### Create the client

```
$client = Client::fromConf($conf);
$client->setWaitForResultEventTimeout(2000);
```

### Call the cluster

```
$results = $client->describeConfigs([
    new ConfigResource((int) $options['t'], (string) $options['v']),
]);
```

### Fetch configuration results

```
foreach ($results as $result) {
    if ($result->error === RD_KAFKA_RESP_ERR_NO_ERROR) {
        // Play around with the configuration options using $result->configs array
    }
}

```


## Using CLI

Finally, if you want to get configuration options for a specific broker using the command line, use the following command to execute the example script:

``` docker-compose run --rm php74 php examples/describe-config.php -t=4 -v=111 -b=kafka:9092 ```

The option ``` -t ``` is for the type of config you want and in our case it should be ``` 4 ``` to get configuration options for a specific broker.

The option ``` -v ``` which is the value of the broker ID that you want to get its own configuration options and in our example we use ``` 111 ```.

The option ``` -b ``` indicates the broker used in our example ``` kafka:9092 ```

And you should see the configuration options for the broker you selected.


## Example

And if you want to get a specific broker's configuration options from scratch, you can use [this](https://github.com/idealo/php-rdkafka-ffi/blob/main/examples/describe-config.php) example instead.
