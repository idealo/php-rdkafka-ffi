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

## Getting started

Build php7.4 base image with ffi enabled (based on php 7.4.0-dev src)

    docker build --no-cache -t php74-cli:latest --build-arg PHP_EXTRA_BUILD_DEPS="libffi-dev" --build-arg PHP_EXTRA_CONFIGURE_ARGS="--with-ffi" ./resources/docker/php74-cli

Test - should show 7.4.0-dev version

    docker run php74-cli php -v

Test - should show FFI in modules list

    docker run php74-cli php -m

Build image with librdkafka

    docker build --no-cache -t php74-ffi-librdkafka ./resources/docker/php74-ffi-librdkafka

Test ffi librdkafka binding - should show 1.0.0 version of librdkafka:

    docker run -v `pwd`:/app -w /app php74-ffi-librdkafka php examples/version.php

## Having fun with examples

Startup php & kafka (scripts use topic 'playground')

    docker-compose up -d

Updating Dependencies (using the [official composer docker image](https://hub.docker.com/_/composer) )

    docker run --rm -it -v `pwd`:/app composer update --ignore-platform-reqs

Producing ...

    docker-compose run --rm app php examples/producer.php

Consuming ...

    docker-compose run --rm app php examples/consumer.php
    
Broker metadata ...

    docker-compose run --rm app php examples/metadata.php

## Run tests

Startup php & kafka (tests use topics 'test*')

    docker-compose up -d
    
Updating Dependencies (using the [official composer docker image](https://hub.docker.com/_/composer) )

    docker run --rm -it -v `pwd`:/app composer update --ignore-platform-reqs

Run tests

    docker-compose run --rm php74 vendor/bin/phpunit

Run tests with coverage:

    docker-compose run --rm php74 vendor/bin/phpunit --coverage-html build/coverage

### Run tests against rdkafka extension / PHP 7.2

Build image with master-dev rdkafka and PHP 7.2:

     docker build --no-cache -t php72-librdkafka ./resources/docker/php72-librdkafka

Updating Dependencies (using the [official composer docker image](https://hub.docker.com/_/composer) )

    docker run --rm -it -v `pwd`:/app composer update --ignore-platform-reqs -d /app/resources/test-extension

Run tests

     docker-compose run --rm php72 resources/test-extension/vendor/bin/phpunit -c resources/test-extension/phpunit.xml

## Todos

* [x] Callbacks (
* [x] High Level KafkaConsumer
* [ ] compatible to librdkafka ^1.0.0
* [ ] compatible to rdkafka extension ^3.1.0
* [ ] sig Handling & destruct (expect seg faults & lost msgs)
* [ ] Tests, tests, tests, ... and travis
* [ ] Generate binding class with https://github.com/ircmaxell/FFIMe / use default header file
* [ ] Support admin features
* [ ] Documentation
