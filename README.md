# Pure PHP Kafka Client library based on php7.4-dev, ffi and librdkafka

__EXTREMLY EXPERIMENTAL WIP__

[![Build Status](https://travis-ci.org/dirx/php-ffi-librdkafka.svg?branch=master)](https://travis-ci.org/dirx/php-ffi-librdkafka)
[![Test Coverage](https://api.codeclimate.com/v1/badges/e60645b9d6d8fa9dd9d6/test_coverage)](https://codeclimate.com/github/dirx/php-ffi-librdkafka/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/e60645b9d6d8fa9dd9d6/maintainability)](https://codeclimate.com/github/dirx/php-ffi-librdkafka/maintainability)

This is a pure PHP Kafka Client library as replacement for [php rdkafka extension](https://github.com/arnaud-lb/php-rdkafka).

Playing around with:

* [ffi extension](https://github.com/php/php-src/tree/PHP-7.4/ext/ffi) for php7.4 ([rfc](https://wiki.php.net/rfc/ffi))
* [librdkafka v1.0.0, v1.1.0, v1.2.0, master](https://github.com/edenhill/librdkafka) ([docs](https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html))
* [php rdkafka stubs](https://github.com/kwn/php-rdkafka-stubs)
* [php7.4-rc](https://github.com/php/php-src/tree/PHP-7.4)
* [wurstmeister/kafka](https://hub.docker.com/r/wurstmeister/kafka/) & official [zookeeper](https://hub.docker.com/_/zookeeper) docker images
* [pcov](https://github.com/krakjoe/pcov) for test code coverage
* [phpbench](https://github.com/phpbench/phpbench) for benchmarking

## Prepare

### Directory overview

* __/benchmarks__ - phpbench based benchmark tests
* __/docs__ - docs dir (md prefered)
* __/examples__ - example scripts
* __/resources__
  * __/docker__
    * __/php74-librdkafka-ffi__ - dockerfile for PHP 7.4 image with librdkafka and ffi & rdkafka ext (based on [php:7.4-rc-cli-stretch](https://hub.docker.com/_/php) )
  * __/test-extension__ - base dir for rdkafka ext compatibility tests
* __/src__ - source dir
* __/tests__ - tests dir 

### Build images

Build all images

    docker-compose build --no-cache --pull
    
Alternative: build the image individually

    docker-compose build --no-cache --pull php74

Test - should show latest 7.4 rc version

    docker-compose run php74 php -v

Test - should show ```FFI``` in modules list

    docker-compose run php74 php -m

Test ffi librdkafka binding - should show 1.0.0 version of librdkafka:

    docker-compose run -v `pwd`:/app -w /app php74 php examples/version.php
   
Test - should show ```rdkafka``` in modules list

    docker-compose run php74 php -dextension=rdkafka.so -m

## Startup

Startup php & kafka

    docker-compose up -d
     
## Having fun with examples

Examples use topic ```playground```.

Updating Dependencies

    docker-compose run --rm --no-deps php74 composer update

Producing ...

    docker-compose run --rm php74 php examples/producer.php

Consuming ...

    docker-compose run --rm php74 php examples/consumer.php
    
Broker metadata ...

    docker-compose run --rm php74 php examples/metadata.php
    
## Run tests

Tests use topics ```test*```.
    
Updating Dependencies

    docker-compose run --rm --no-deps php74 composer update

Run tests

    docker-compose run --rm php74 vendor/bin/phpunit

Run tests with coverage

    docker-compose run --rm php74 vendor/bin/phpunit --coverage-html build/coverage

### Run tests against rdkafka extension / PHP 7.4

Updating Dependencies

    docker-compose run --rm --no-deps php74 composer update -d /app/resources/test-extension --ignore-platform-reqs

Run tests

     docker-compose run --rm php74 php -dextension=rdkafka.so resources/test-extension/vendor/bin/phpunit -c resources/test-extension/phpunit.xml

## Run benchmarks

Benchmarks use topic ```benchmarks```.

Run & store benchmarks for ffi based rdkafka binding

    docker-compose run --rm php74 phpbench run benchmarks --config=/app/benchmarks/ffi.json --report=default --store --tag=ffi

Run & store benchmarks for extension based rdkafka binding

    docker-compose run --rm php74 phpbench run benchmarks --config=/app/benchmarks/ext.json --report=default --store --tag=ext    

Show comparison

    docker-compose run --rm php74 phpbench report --uuid=tag:ffi --uuid=tag:ext --report='{extends: compare, compare: tag}'

### Benchmarks

Just some first benchmarks based on PHP74-RC1, librdkafka v1.0.0, ext latest master, ffi without preload enabled.

| benchmark     | subject                      | set | revs | tag:ffi:mean | tag:ext:mean |
|---------------|------------------------------|-----|------|--------------|--------------|
| ConsumerBench | benchConsume1Message         | 0   | 100  | 28,418.128μs | 26,091.144μs |
| ConsumerBench | benchConsume100Messages      | 0   | 100  | 40,182.836μs | 38,656.394μs |
| ConsumerBench | benchConsumeBatch100Messages | 0   | 100  | 35,136.240μs | 27,183.174μs |
| ProducerBench | benchProduce1Message         | 0   | 100  | 4,076.694μs  | 3,563.914μs  |
| ProducerBench | benchProduce100Messages      | 0   | 100  | 3,663.710μs  | 3,731.920μs  |

See concrete [benchmarks details](./docs/benchmarks.md) for ffi & extension bindings.

## Shutdown & cleanup

Shutdown and remove volumes:

    docker-compose down -v

## Todos

* [x] Callbacks
* [x] High Level KafkaConsumer
* [x] Tests, tests, tests, ... and travis
* [x] Support admin features
* [x] Compatible to librdkafka ^1.0.0
* [x] Benchmarking against rdkafka extension
* [ ] Documentation
* [ ] Compatible to rdkafka extension ^3.1.0
* [ ] Generate binding class with https://github.com/ircmaxell/FFIMe / use default header file
* [ ] Sig Handling & destruct (expect seg faults & lost msgs & shutdown hangs)
* [ ] Provide ffi preload
