# Try out

Checkout this repo and have some fun playing around with:

* [FFI extension](https://www.php.net/manual/en/book.ffi.php)
* [librdkafka ^1.0](https://github.com/edenhill/librdkafka) ([docs](https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html))
* [PHP ^7.4](https://www.php.net/archive/2019.php#2019-11-28-1) and [PHP ^8.0](https://www.php.net/archive/2020.php#2020-11-26-3)
* Confluent [Kafka](https://hub.docker.com/r/confluentinc/cp-kafka) / [Zookeeper](https://hub.docker.com/r/confluentinc/cp-zookeeper) docker images
* [phpbench lib](https://github.com/phpbench/phpbench) for benchmarking

## Directory overview

* __/benchmarks__ - phpbench based benchmark tests
* __/docs__ - docs dir (markdown)
* __/examples__ - example scripts
* __/resources__
    * __/benchmarks__ ansible playbooks setup and run benchmarks
    * __/docker__
       * __/php74-librdkafka-ffi__ - dockerfile for PHP 7.4 image with librdkafka and ffi & rdkafka ext (based on [php:7.4-cli](https://hub.docker.com/_/php) )
       * __/php80-librdkafka-ffi__ - dockerfile for PHP 8.0 image with librdkafka and ffi & rdkafka ext (based on [php:8.0-rc-cli](https://hub.docker.com/_/php) )
    * __/docs__ - scripts to build documentation site from /docs
    * __/ffigen__ - rebuild stuff low level library bindings
    * __/phpunit__ - bootstrap and config for phpunit tests
    * __/test-extension__ - base dir for rdkafka ext compatibility tests
* __/src__ - source dir
* __/tests__ - tests dir

## Build images

Build all images

    docker-compose build --no-cache --pull

Alternative: build the image individually

    docker-compose build --no-cache --pull php74

Alternative: build the image individually and set optional build args (LIBRDKAFKA_VERSION default = v1.5.3, RDKAFKA_EXT_VERSION default = master)

    docker-compose build --no-cache --pull --build-arg LIBRDKAFKA_VERSION="v1.5.3" --build-arg RDKAFKA_EXT_VERSION="4.1.1" php74

Test - should show latest 7.4 version

    docker-compose run php74 php -v

Test - should show ```FFI``` in modules list

    docker-compose run php74 php -m

Test ffi librdkafka binding - should show current version of librdkafka:

    docker-compose run php74 php examples/version.php

Test - should show ```rdkafka``` in modules list

    docker-compose run php74 php -dextension=rdkafka.so -m

## Startup

Startup php & kafka

    docker-compose up -d

Updating dependencies

    docker-compose run --rm --no-deps php74 composer update

Create required topics

    docker-compose run --rm php74 php examples/create-topic.php -tplayground -p3 -r1 && \
    docker-compose run --rm php74 php examples/create-topic.php -ttest -p1 -r1 && \
    docker-compose run --rm php74 php examples/create-topic.php -ttest_partitions -p3 -r1 && \
    docker-compose run --rm php74 php examples/create-topic.php -tbenchmarks -p1 -r1

## Having fun with examples

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

Test preload (shows current librdkafka version & opcache status)

    docker-compose run --rm php80 php \
        -dffi.enable=preload \
        -dzend_extension=opcache \
        -dopcache.enable=true \
        -dopcache.enable_cli=true \
        -dopcache.preload_user=phpdev \
        -dopcache.preload=/app/examples/preload.php \
        examples/test-preload.php

Test preload with jit (shows current librdkafka version & opcache status)

    docker-compose run --rm php80 php \
        -dffi.enable=preload \
        -dzend_extension=opcache \
        -dopcache.enable=true \
        -dopcache.enable_cli=true \
        -dopcache.preload_user=phpdev \
        -dopcache.preload=/app/examples/preload.php \
        -dopcache.jit_buffer_size=100M \
        -dopcache.jit=function \
        examples/test-preload.php

__Experimental__! Test mock cluster (producing and consuming) - requires librdkafka ^1.3.0

     docker-compose run --rm php74 php examples/mock-cluster.php

__Experimental__! Read consumer offset lags

     docker-compose run --rm php74 php examples/offset-lags.php

Delete topic ```playground``` ...

    docker-compose run --rm php74 php examples/delete-topic.php -tplayground

## Run tests

Tests use topics ```test*```.

Updating Dependencies

    docker-compose run --rm --no-deps php74 composer update

Run tests

    docker-compose run --rm php74 vendor/bin/phpunit

Run tests with coverage

    docker-compose run --rm -e -XDEBUG_MODE=coverage php74 vendor/bin/phpunit --coverage-text --coverage-clover=clover.xml

### Run tests against RdKafka extension / PHP 7.4

Updating Dependencies

    docker-compose run --rm --no-deps php74 composer update -d /app/resources/test-extension --ignore-platform-reqs

Run tests

     docker-compose run --rm php74 php -dextension=rdkafka.so resources/test-extension/vendor/bin/phpunit -c resources/test-extension/phpunit.xml

## Run benchmarks

Benchmarks use topic ```benchmarks```.

Run Benchmarks

    docker-compose down -v; \
    docker-compose up -d kafka; \
    sleep 10s; \
    docker-compose run --rm php74 php examples/create-topic.php -tbenchmarks -p1 -r1; \
    docker-compose run --rm php74 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi.json --report=default --store --tag=php74_ffi --group=ffi; \
    docker-compose run --rm php74 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi_preload.json --report=default --store --tag=php74_ffi_preload --group=ffi; \
    docker-compose run --rm php80 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi.json --report=default --store --tag=php80_ffi --group=ffi; \
    docker-compose run --rm php80 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi_preload.json --report=default --store --tag=php80_ffi_preload --group=ffi; \
    docker-compose run --rm php80 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi_jit.json --report=default --store --tag=php80_ffi_preload_jit --group=ffi; \
    docker-compose run --rm php74 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ext.json --report=default --store --tag=php74_ext --group=ext

Show comparison for runtime mean

    docker-compose run --rm php74 vendor/bin/phpbench report \
        --uuid=tag:php74_ffi \
        --uuid=tag:php74_ffi_preload \
        --uuid=tag:php80_ffi \
        --uuid=tag:php80_ffi_preload \
        --uuid=tag:php80_ffi_preload_jit \
        --uuid=tag:php74_ext \
        --report='{extends: compare, compare: tag, compare_fields: [mean]}'

Show comparison for memory peak

    docker-compose run --rm php74 vendor/bin/phpbench report \
        --uuid=tag:php74_ffi \
        --uuid=tag:php74_ffi_preload \
        --uuid=tag:php80_ffi \
        --uuid=tag:php80_ffi_preload \
        --uuid=tag:php80_ffi_preload_jit \
        --uuid=tag:php74_ext \
        --report='{extends: compare, compare: tag, compare_fields: [mem_peak]}'

Run Api::init benchmark (fix vs auto detected version)

    docker-compose run --rm php74 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi.json --report=default --group=Api

## Work on the documentation

Documentation is based on `markdown` and the static site is build with [mkdocs material](https://squidfunk.github.io/mkdocs-material/).
The API documentation is generated by [dog](https://klitsche.github.io/dog/) as markdown.

Serve documentation on http://localhost:8000/

    docker-compose run --rm php74 composer prepare-docs
    docker-compose up mkdocs

Build static site in folder site

    docker-compose run --rm php74 composer prepare-docs
    docker-compose run --rm mkdocs build