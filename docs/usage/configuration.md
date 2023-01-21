# Configuration

!!! Tip

    See [librdkafka CONFIGURATION](https://github.com/confluentinc/librdkafka/blob/master/CONFIGURATION.md) for available parameters

## Set, Get & Dump

!!! Note

    Values are always of type `string`.

```php
// create config
$conf = new \RdKafka\Conf();

$conf->set('log_level', (string) LOG_DEBUG);

var_dump($conf->get('log_level'));
var_dump($conf->dump());
```

## Logging

The default is to print to stderr. Alternatively the application may provide its own logger callback. Or call `setLogCb(null)` to disable
logging.

```php
// create config
$conf = new \RdKafka\Conf();

// enable logging
$conf->set('log_level', (string) LOG_DEBUG);
$conf->set('debug', 'all');
$conf->setLogCb(
    function (\RdKafka $rdkafka, int $level, string $facility, string $message): void {
        echo sprintf("log: %d %s %s", $level, $fac, $buf) . PHP_EOL;
    }
);
```

## Error Handling

The error callback is used by librdkafka to signal warnings and errors back to the application.

These errors should generally be considered informational and non-permanent, the client will try to recover automatically from all type of
errors. Given that the client and cluster configuration is correct the application should treat these as temporary errors.

The error callback will be triggered with err set to RD_KAFKA_RESP_ERR__FATAL if a fatal error has been raised; in this case use
rd_kafka_fatal_error() to retrieve the fatal error code and error string, and then begin terminating the client instance.

```php
// create config
$conf = new \RdKafka\Conf();
$conf->setErrorCb(
    function (\RdKafka $rdkafka, int $err, string $reason, $opaque = null): void 
    {
        echo sprintf("Error %d %s. Reason: %s", $err, rd_kafka_err2str($err), $reason) . PHP_EOL;
        if ($err === RD_KAFKA_RESP_ERR__FATAL) {
            throw new \RuntimeException('fatal error');
        }
    }
);
```

## Read Statistics

!!! Tip

    See https://github.com/confluentinc/librdkafka/blob/master/STATISTICS.md for a detailed list of emitted metrics.

```php
// create config
$conf = new \RdKafka\Conf();
$conf->setStatsCb(
    function ($consumerOrProducer, string $json, int $jsonLength, $opaque = null): void 
    {
        var_dump(\json_decode($json, true));
    }
);
```

## Monitor Message Delivery

__Producer only.__

Keep track of message delivery and react on final delivery errors.

!!! Note

    Please read about [librdkafka & its message reliability](https://github.com/confluentinc/librdkafka/blob/master/INTRODUCTION.md#message-reliability) to fully understand why delivery of messages can fail and how to handle failures.

```php
$conf->setDrMsgCb(
    function (\RdKafka\Producer $producer, \RdKafka\Message $message): void {
        if ($message->err !== RD_KAFKA_RESP_ERR_NO_ERROR) {
            // handle delivery errors
        }
    }
);
```