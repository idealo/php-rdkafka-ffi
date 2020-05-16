# PHP Kafka client - binding librdkafka via FFI

__WIP__

[![Build Status](https://travis-ci.org/dirx/php-ffi-librdkafka.svg?branch=master)](https://travis-ci.org/dirx/php-ffi-librdkafka)
[![Test Coverage](https://api.codeclimate.com/v1/badges/e60645b9d6d8fa9dd9d6/test_coverage)](https://codeclimate.com/github/dirx/php-ffi-librdkafka/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/e60645b9d6d8fa9dd9d6/maintainability)](https://codeclimate.com/github/dirx/php-ffi-librdkafka/maintainability)

This is a Kafka client library for PHP ^7.4 with a slim [librdkafka](https://github.com/edenhill/librdkafka) binding via FFI.
It is intended as a replacement for the [PHP RdKafka extension](https://github.com/arnaud-lb/php-rdkafka).

## Usage

There is no pre-release yet. Please do not use in production.

### Requirements

* PHP ^7.4 with extensions FFI and pcntl
* librdkafka ^1.0.0

Note: Support for macOS and Windows is currently experimental and very very very unstable.

## Try out & contribute

Checkout this repo and have some fun playing around with:

* [FFI extension](https://www.php.net/manual/en/book.ffi.php)
* [librdkafka ^1.0](https://github.com/edenhill/librdkafka) ([docs](https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html))
* [PHP ^7.4](https://www.php.net/archive/2019.php#2019-11-28-1)
* Confluent [Kafka](https://hub.docker.com/r/confluentinc/cp-kafka) / [Zookeeper](https://hub.docker.com/r/confluentinc/cp-zookeeper) docker images
* [phpbench lib](https://github.com/phpbench/phpbench) for benchmarking

### Directory overview

* __/benchmarks__ - phpbench based benchmark tests
* __/docs__ - docs dir (md prefered)
* __/examples__ - example scripts
* __/resources__
  * __/docker__
    * __/php74-librdkafka-ffi__ - dockerfile for PHP 7.4 image with librdkafka and ffi & rdkafka ext (based on [php:7.4-cli](https://hub.docker.com/_/php) )
  * __/ffigen__ - rebuild stuff low level library bindings
  * __/phpunit__ - bootstrap and config for phpunit tests
  * __/test-extension__ - base dir for rdkafka ext compatibility tests
* __/src__ - source dir
* __/tests__ - tests dir

### Build images

Build all images

    docker-compose build --no-cache --pull

Alternative: build the image individually

    docker-compose build --no-cache --pull php74

Alternative: build the image individually and set optional build args (LIBRDKAFKA_VERSION default = v1.0.0, RDKAFKA_EXT_VERSION default = master)

    docker-compose build --no-cache --pull --build-arg LIBRDKAFKA_VERSION="v1.4.0" --build-arg RDKAFKA_EXT_VERSION="4.0.3" php74

Test - should show latest 7.4 version

    docker-compose run php74 php -v

Test - should show ```FFI``` in modules list

    docker-compose run php74 php -m

Test ffi librdkafka binding - should show current version of librdkafka:

    docker-compose run php74 php examples/version.php

Test - should show ```rdkafka``` in modules list

    docker-compose run php74 php -dextension=rdkafka.so -m

### Startup

Startup php & kafka

    docker-compose up -d

Updating dependencies

    docker-compose run --rm --no-deps php74 composer update

Create required topics

    docker-compose run --rm php74 php examples/create-topic.php -tplayground -p3 -r1 && \
    docker-compose run --rm php74 php examples/create-topic.php -ttest -p1 -r1 && \
    docker-compose run --rm php74 php examples/create-topic.php -ttest_partitions -p3 -r1 && \
    docker-compose run --rm php74 php examples/create-topic.php -tbenchmarks -p1 -r1 

### Having fun with examples

Examples use topic ```playground```.

Updating Dependencies

    docker-compose run --rm --no-deps php74 composer update

Create topic ```playground``` ...

    docker-compose run --rm php74 php examples/create-topic.php -tplayground -p3 -r1

Producing ...

    docker-compose run --rm php74 php examples/producer.php

Consuming (with low level consumer) ...

    docker-compose run --rm php74 php examples/consumer.php

Consuming (with high level consumer) ...

    docker-compose run --rm -T php74 php examples/consumer-highlevel.php

Broker metadata ...

    docker-compose run --rm php74 php examples/metadata.php
    
Describe config values for a topic ...

    docker-compose run --rm php74 php examples/describe-config.php
    docker-compose run --rm php74 php examples/describe-config.php -t2 -vtest

Describe config values for a broker ...

    docker-compose run --rm php74 php examples/describe-config.php -t4 -v111

Test preload (should show current librdkafka version)

    docker-compose run --rm php74 php \
        -dffi.enable=preload \
        -dzend_extension=opcache \
        -dopcache.enable=true \
        -dopcache.enable_cli=true \
        -dopcache.preload_user=phpdev \
        -dopcache.preload=/app/examples/preload.php \
        examples/test-preload.php

__Experimental__! Test mock cluster (producing and consuming) - requires librdkafka ^1.3.0

     docker-compose run --rm php74 php examples/mock-cluster.php

__Experimental__! Read consumer offset lags

     docker-compose run --rm php74 php examples/offset-lags.php

Delete topic ```playground``` ...

    docker-compose run --rm php74 php examples/delete-topic.php -tplayground

### Run tests

Tests use topics ```test*```.

Updating Dependencies

    docker-compose run --rm --no-deps php74 composer update

Run tests

    docker-compose run --rm php74 vendor/bin/phpunit

Run tests with coverage

    docker-compose run --rm php74 vendor/bin/phpunit --coverage-html build/coverage

#### Run tests against RdKafka extension / PHP 7.4

Updating Dependencies

    docker-compose run --rm --no-deps php74 composer update -d /app/resources/test-extension --ignore-platform-reqs

Run tests

     docker-compose run --rm php74 php -dextension=rdkafka.so resources/test-extension/vendor/bin/phpunit -c resources/test-extension/phpunit.xml

### Run benchmarks

Benchmarks use topic ```benchmarks```.

Run & store benchmarks for ffi based rdkafka binding

    docker-compose down -v; \
    docker-compose up -d kafka; \
    sleep 10s; \
    docker-compose run --rm php74 php examples/create-topic.php -tbenchmarks -p1 -r1; \
    docker-compose run --rm php74 phpbench run benchmarks --config=/app/benchmarks/ffi.json --report=default --store --tag=ffi --group=ffi

Run & store benchmarks for extension based rdkafka binding

    docker-compose down -v; \
    docker-compose up -d kafka; \
    sleep 10s; \
    docker-compose run --rm php74 php examples/create-topic.php -tbenchmarks -p1 -r1; \
    docker-compose run --rm php74 phpbench run benchmarks --config=/app/benchmarks/ext.json --report=default --store --tag=ext --group=ext

Show comparison

    docker-compose run --rm php74 phpbench report --uuid=tag:ffi --uuid=tag:ext --report='{extends: compare, compare: tag}'

Run Api::init benchmark (fix vs auto detected version)

    docker-compose run --rm php74 phpbench run benchmarks --config=/app/benchmarks/ffi.json --report=default --group=Api

#### Benchmarks

Some benchmarks based on PHP 7.4.1, librdkafka v1.3.0, ext latest master (4.0.3-dev), ffi with preload enabled.

| benchmark     | subject                                         | set | revs | tag:ffi:mean | tag:ext:mean |
|---------------|-------------------------------------------------|-----|------|--------------|--------------|
| ConsumerBench | benchConsume1Message                            | 0   | 100  | 28,321.140μs | 27,761.178μs |
| ConsumerBench | benchConsumeCallback1Message                    | 0   | 100  | 28,499.664μs | 27,838.560μs |
| ConsumerBench | benchConsume100Messages                         | 0   | 100  | 39,748.522μs | 38,886.366μs |
| ConsumerBench | benchConsume100MessagesWithLogCallback          | 0   | 100  | 41,097.162μs | 39,148.838μs |
| ConsumerBench | benchConsumeBatch100Messages                    | 0   | 100  | 32,116.332μs | 27,272.554μs |
| ConsumerBench | benchConsumeCallback100Message                  | 0   | 100  | 35,445.358μs | 27,619.512μs |
| ProducerBench | benchProduce1Message                            | 0   | 100  | 3,776.272μs  | 3,654.974μs  |
| ProducerBench | benchProduce100Messages                         | 0   | 100  | 3,844.302μs  | 3,847.884μs  |
| ProducerBench | benchProduce100MessagesWithLogAndDrMsgCallbacks | 0   | 100  | 5,613.870μs  | 4,250.210μs  |

See concrete [benchmarks details](./docs/benchmarks.md) for ffi & extension bindings.

### Shutdown & cleanup

Shutdown and remove volumes:

    docker-compose down -v

### Todos

* [x] Callbacks
* [x] High Level KafkaConsumer
* [x] Tests, tests, tests, ... and travis
* [x] Support admin features
* [x] Compatible to librdkafka ^1.0.0
* [x] Benchmarking against rdkafka extension
* [x] Provide ffi preload
* [x] Compatible to rdkafka extension ^4.0
* [x] Add version specific binding for librdkafka to handle (changed) const values correctly and provide support for new features
* [ ] Sig Handling & destruct (expect seg faults & lost msgs & shutdown hangs)
* [ ] Documentation
* [ ] Prepare for composer & first release
