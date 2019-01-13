# rdkafka lib based on PHP 7.4, FFI extension and librdkafka

__EXTREMLY EXPERIMENTAL WIP__

A php based rdkafka lib as replacement for [php rdkafka extension]()https://github.com/arnaud-lb/php-rdkafka .

Playing around with

* experimental [php ffi extension](https://github.com/dstogov/php-ffi) for php7.4 ([rfc](https://wiki.php.net/rfc/ffi))
* [librdkafka 0.11.6](https://github.com/edenhill/librdkafka) ([docs](https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html))
* [php rdkafka stubs](https://github.com/kwn/php-rdkafka-stubs)
* php7.4-dev

## Get started

Build php7.4 base container (based on php master src)

    docker build -t php74-cli ./docker/php74-cli

Test - should show 7.4.0-dev version

    docker run -it php74-cli php -v

Build container with ffi & librdkafka

    docker build -t ffi-kafka ./docker/ffi-kafka

Test - should show FFI in modules list

    docker run -it ffi-kafka php -m

Test ffi kafka lib binding - should show 0.11.6 version of librdkafka:

    docker run -it -v `pwd`:/app -w /app ffi-kafka php bin/version.php

## Having fun with kafka

Startup php & kafka (with topic ffi)

    docker-compose up -d

Updating Dependencies

    docker-compose run app composer update

Producing ...

    docker-compose run app php app/bin/producer.php

Consuming ...

    docker-compose run app php app/bin/consumer.php

## Todos

* MetaData API Support
* Callbacks (are currently not fully supported by ffi)
* High Level KafkaConsumer
* Logging
* sig Handling
* Tests
