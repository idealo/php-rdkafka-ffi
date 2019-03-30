# rdkafka lib based on PHP 7.4 dev, FFI extension and librdkafka

__EXTREMLY EXPERIMENTAL WIP__

A php based rdkafka lib as replacement for [php rdkafka extension](https://github.com/arnaud-lb/php-rdkafka).

Playing around with

* [ffi extension](https://github.com/php/php-src/tree/PHP-7.4/ext/ffi) for php7.4 ([rfc](https://wiki.php.net/rfc/ffi))
* [librdkafka 1.0.0](https://github.com/edenhill/librdkafka) ([docs](https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html))
* [php rdkafka stubs](https://github.com/kwn/php-rdkafka-stubs)
* [php7.4-dev](https://github.com/php/php-src/tree/PHP-7.4)
* [Kafka](https://hub.docker.com/r/wurstmeister/kafka/) / [Zookeeper](https://hub.docker.com/r/wurstmeister/zookeeper/) docker images from wurstmeister

## Get started

Build php7.4 base container with ffi enabled (based on php 7.4.0-dev src)

    docker build --no-cache -t php74-cli:latest --build-arg PHP_EXTRA_BUILD_DEPS="libffi-dev" --build-arg PHP_EXTRA_CONFIGURE_ARGS="--with-ffi --without-pear" ./docker/php74-cli

Test - should show 7.4.0-dev version

    docker run -it php74-cli php -v

Test - should show FFI in modules list

    docker run -it php-ffi-librdkafka php -m

Build container with librdkafka

    docker build --no-cache -t php-ffi-librdkafka ./docker/php-ffi-librdkafka

Test ffi librdkafka binding - should show 1.0.0 version of librdkafka:

    docker run -it -v `pwd`:/app -w /app php-ffi-librdkafka php bin/version.php

## Having fun with kafka

Startup php & kafka (with topic ffi)

    docker-compose up -d

Updating Dependencies (using the [official composer docker image](https://hub.docker.com/_/composer) )

    docker run --rm --interactive --tty -v $PWD:/app composer update

Producing ...

    docker-compose run app php bin/producer.php

Consuming ...

    docker-compose run app php bin/consumer.php
    
Broker metadata ...

    docker-compose run app php bin/metadata.php

## Todos

* Callbacks (log & msg callback kind of work, look into rd_kafka_conf_set_background_event_cb)
* High Level KafkaConsumer
* sig Handling & destruct (expect seg faults & lost msgs)
* Tests, tests, tests, ... and travis
* Generate binding class with https://github.com/ircmaxell/FFIMe
* Support admin

