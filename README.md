# Pure PHP Kafka Client library based on php7.4-dev, ffi and librdkafka

__EXTREMLY EXPERIMENTAL WIP__

[![Build Status](https://travis-ci.org/dirx/php-ffi-librdkafka.svg?branch=master)](https://travis-ci.org/dirx/php-ffi-librdkafka)
[![Test Coverage](https://api.codeclimate.com/v1/badges/e60645b9d6d8fa9dd9d6/test_coverage)](https://codeclimate.com/github/dirx/php-ffi-librdkafka/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/e60645b9d6d8fa9dd9d6/maintainability)](https://codeclimate.com/github/dirx/php-ffi-librdkafka/maintainability)

This is a pure PHP Kafka Client library as replacement for [php rdkafka extension](https://github.com/arnaud-lb/php-rdkafka).

Playing around with:

* [ffi extension](https://github.com/php/php-src/tree/PHP-7.4/ext/ffi) for php7.4 ([rfc](https://wiki.php.net/rfc/ffi))
* [librdkafka 1.0.0](https://github.com/edenhill/librdkafka) ([docs](https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html))
* [php rdkafka stubs](https://github.com/kwn/php-rdkafka-stubs)
* [php7.4-dev](https://github.com/php/php-src/tree/PHP-7.4)
* [Kafka](https://hub.docker.com/r/wurstmeister/kafka/) / [Zookeeper](https://hub.docker.com/r/wurstmeister/zookeeper/) docker images from wurstmeister
* [pcov](https://github.com/krakjoe/pcov) for test code coverage
* [phpbench](https://github.com/phpbench/phpbench) for benchmarking

## Prepare

### Directory overview

* __/benchmarks__ - phpbench based benchmark tests
* __/examples__ - example scripts
* __/resources__
  * __/docker__
    * __/php74-librdkafka-ffi__ - dockerfile for PHP 7.4 image with librdkafka and ffi enabled (based on [php:7.4-rc-cli-stretch](https://hub.docker.com/_/php) )
    * __/php72-librdkafka-ext__ - dockerfile for PHP 7.2 image with librdkafka and rdkafka ext (from master-dev) for compatibility tests
  * __/test-extension__ - base dir for php72 rdkafka ext compatibility tests
* __/src__ - source dir
* __/tests__ - tests dir 

### Build images

Build all images

    docker-compose build --no-cache --pull
    
Alternative: build the images individually

    docker-compose build --no-cache --pull php74
    docker-compose build --no-cache --pull php72

Test - should show latest 7.4 rc version

    docker-compose run php74 php -v

Test - should show ```FFI``` in modules list

    docker-compose run php74 php -m

Test ffi librdkafka binding - should show 1.0.0 version of librdkafka:

    docker-compose run -v `pwd`:/app -w /app php74 php examples/version.php
   
Test - should show ```rdkafka``` in modules list

    docker-compose run php72 php -m

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

    docker-compose run --rm --no-deps php74-ext php composer update -d /app/resources/test-extension

Run tests

     docker-compose run --rm php74-ext php resources/test-extension/vendor/bin/phpunit -c resources/test-extension/phpunit.xml

### Run benchmarks

Run & store benchmarks for ffi based rdkafka binding

    docker-compose run --rm php74 phpbench run benchmarks/ProducerBench.php --config=/app/benchmarks/ffi.json --report=default --store --tag=ffi

Run & store benchmarks for extension based rdkafka binding

    docker-compose run --rm php74 phpbench run benchmarks/ProducerBench.php --config=/app/benchmarks/ext.json --report=default --store --tag=ext    

Show comparison

    docker-compose run --rm php74 phpbench report --uuid=tag:ffi --uuid=tag:ext --report='{extends: compare, compare: tag}'

#### Benchmarks

Just some first benchmarks:

##### FFI Binding

| benchmark     | subject                 | set | revs | iter | mem_peak   | time_rev    | comp_z_value | comp_deviation |
|---------------|-------------------------|-----|------|------|------------|-------------|--------------|----------------|
| ProducerBench | benchProduce1Message    | 0   | 1000 | 0    | 1,112,584b | 2,181.850μs | |1.88σ       | |4.31%         |
| ProducerBench | benchProduce1Message    | 0   | 1000 | 1    | 1,112,584b | 2,095.888μs | |0.09σ       | |0.20%         |
| ProducerBench | benchProduce1Message    | 0   | 1000 | 2    | 1,112,584b | 2,062.261μs | -0.62σ       | -1.41%         |
| ProducerBench | benchProduce1Message    | 0   | 1000 | 3    | 1,112,584b | 2,072.470μs | -0.4σ        | -0.92%         |
| ProducerBench | benchProduce1Message    | 0   | 1000 | 4    | 1,112,584b | 2,046.090μs | -0.95σ       | -2.18%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 0    | 1,112,584b | 2,068.870μs | -0.25σ       | -1.36%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 1    | 1,112,584b | 1,942.630μs | -1.34σ       | -7.38%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 2    | 1,112,584b | 2,024.420μs | -0.63σ       | -3.48%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 3    | 1,112,584b | 2,184.520μs | |0.76σ       | |4.15%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 4    | 1,112,584b | 2,266.550μs | |1.47σ       | |8.06%         |

##### Extension Binding

| benchmark     | subject                 | set | revs | iter | mem_peak | time_rev    | comp_z_value | comp_deviation |
|---------------|-------------------------|-----|------|------|----------|-------------|--------------|----------------|
| ProducerBench | benchProduce1Message    | 0   | 1000 | 0    | 873,248b | 1,945.637μs | -1.17σ       | -4.72%         |
| ProducerBench | benchProduce1Message    | 0   | 1000 | 1    | 873,248b | 1,942.173μs | -1.21σ       | -4.89%         |
| ProducerBench | benchProduce1Message    | 0   | 1000 | 2    | 873,248b | 2,098.593μs | |0.69σ       | |2.77%         |
| ProducerBench | benchProduce1Message    | 0   | 1000 | 3    | 873,248b | 2,142.959μs | |1.22σ       | |4.95%         |
| ProducerBench | benchProduce1Message    | 0   | 1000 | 4    | 873,248b | 2,080.549μs | |0.47σ       | |1.89%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 0    | 873,248b | 1,918.190μs | -1.21σ       | -4.96%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 1    | 873,248b | 2,065.260μs | |0.57σ       | |2.32%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 2    | 873,248b | 1,947.300μs | -0.86σ       | -3.52%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 3    | 873,248b | 2,147.980μs | |1.57σ       | |6.42%         |
| ProducerBench | benchProduce100Messages | 0   | 100  | 4    | 873,248b | 2,013.150μs | -0.06σ       | -0.26%         |

##### Compared

| benchmark     | subject                 | set | revs | tag:ffi:mean | tag:ext:mean |
|---------------|-------------------------|-----|------|--------------|--------------|
| ProducerBench | benchProduce1Message    | 0   | 1000 | 2,091.712μs  | 2,041.982μs  |
| ProducerBench | benchProduce100Messages | 0   | 100  | 2,097.398μs  | 2,018.376μs  |


## Shutdown & cleanup

Shutdown and remove volumes:

    docker-compose down -v

## Todos

* [x] Callbacks
* [x] High Level KafkaConsumer
* [ ] Compatible to librdkafka ^1.0.0
* [ ] Compatible to rdkafka extension ^3.1.0
* [ ] Sig Handling & destruct (expect seg faults & lost msgs & shutdown hangs)
* [ ] Tests, tests, tests, ... and travis
* [ ] Benchmarking against rdkafka extension
* [ ] Generate binding class with https://github.com/ircmaxell/FFIMe / use default header file
* [ ] Support admin features
* [ ] Documentation
