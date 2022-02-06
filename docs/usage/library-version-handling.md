# Library Version Handling

There are 2 versions:

* the version of librdkafka
* the version of the librdkafka binding

The librdkafka version and the matching binding version is auto-detected by default. 

## Get version
Get the version of librdkafka

```php
echo \RdKafka\FFI\Library::rd_kafka_version();
```

Get the version of the librdkafka binding

```php  
echo RdKafka\FFI\Library::getLibraryVersion();
```

## Set binding version manually

In some situations it may be required to initialize the binding version manually.

```php
use RdKafka\FFI\Library;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$version = getenv('LIBRDKAFKA_VERSION') ?: Library::VERSION_AUTODETECT;
Library::init($version);
```

!!! Tip

    The binding will (usually) fail if you choose a higher version than the actual librdkafka version.
