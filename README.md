# rdkafka lib based on PHP 7.4 dev, FFI extension and librdkafka

__EXTREMLY EXPERIMENTAL WIP__

A php based rdkafka lib as replacement for [php rdkafka extension](https://github.com/arnaud-lb/php-rdkafka).

Playing around with

* [ffi extension](https://github.com/php/php-src/tree/PHP-7.4/ext/ffi) for php7.4 ([rfc](https://wiki.php.net/rfc/ffi))
* [librdkafka 0.11.6](https://github.com/edenhill/librdkafka) ([docs](https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html))
* [php rdkafka stubs](https://github.com/kwn/php-rdkafka-stubs)
* [php7.4-dev](https://github.com/php/php-src/tree/PHP-7.4)
* [Kafka](https://hub.docker.com/r/wurstmeister/kafka/) / [Zookeeper](https://hub.docker.com/r/wurstmeister/zookeeper/) docker images from wurstmeister

## Get started

Build php7.4 base container with ffi enabled (based on php 7.4.0-dev src)

    docker build -t php74-cli:latest --build-arg PHP_EXTRA_BUILD_DEPS="libffi-dev" --build-arg PHP_EXTRA_CONFIGURE_ARGS="--with-ffi --without-pear" ./docker/php74-cli

Test - should show 7.4.0-dev version

    docker run -it php74-cli php -v

Test - should show FFI in modules list

    docker run -it php-ffi-librdkafka php -m

Build container with librdkafka

    docker build -t php-ffi-librdkafka ./docker/php-ffi-librdkafka

Test ffi librdkafka binding - should show 0.11.6 version of librdkafka:

    docker run -it -v `pwd`:/app -w /app php-ffi-librdkafka php bin/version.php

## Having fun with kafka

Startup php & kafka (with topic ffi)

    docker-compose up -d

Updating Dependencies (using the [official composer docker image](https://hub.docker.com/_/composer) )

    docker run --rm --interactive --tty -v $PWD:/app composer update

Producing ...

    docker-compose run app php app/bin/producer.php

Consuming ...

    docker-compose run app php app/bin/consumer.php
    
Broker metadata ...

    docker-compose run app php app/bin/metadata.php

## Todos

* Callbacks (currently not fully supported by ffi and do work really quirky)
* High Level KafkaConsumer
* Logging
* sig Handling & destruct
* Tests
