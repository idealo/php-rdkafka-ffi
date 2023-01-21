# Project Overview

## Directory overview

* __/benchmarks__ - phpbench based benchmark tests
* __/docs__ - docs dir (markdown)
* __/examples__ - example scripts
* __/resources__
    * __/benchmarks__ ansible playbooks setup and run benchmarks
    * __/docker__
        * __/php74-librdkafka-ffi__ - dockerfile for PHP 7.4 image with librdkafka and ffi & rdkafka ext (based
          on [php:7.4-cli](https://hub.docker.com/_/php) )
        * __/php80-librdkafka-ffi__ - dockerfile for PHP 8.0 image with librdkafka and ffi & rdkafka ext (based
          on [php:8.0-rc-cli](https://hub.docker.com/_/php) )
    * __/docs__ - scripts to build documentation site from /docs
    * __/ffigen__ - config to build low level library bindings
    * __/phpunit__ - bootstrap and config for phpunit tests
    * __/test-extension__ - base dir for rdkafka ext compatibility tests
* __/src__ - source dir
* __/tests__ - tests dir

## Docker Images for Development

Build all images

    docker-compose build --no-cache --pull

Alternative: build the image individually

    docker-compose build --no-cache --pull php74 php80

Alternative: build the image individually and set optional build args (LIBRDKAFKA_VERSION default = v1.5.3, RDKAFKA_EXT_VERSION default =
4.1.x for php74 / 5.x for php80)

    docker-compose build --no-cache --pull --build-arg LIBRDKAFKA_VERSION="v1.5.3" --build-arg RDKAFKA_EXT_VERSION="4.1.1" php74

Test - should show latest 7.4 version

    docker-compose run php74 php -v

Test - should show ```FFI``` in modules list

    docker-compose run php74 php -m

Test ffi librdkafka binding - should show current version of librdkafka:

    docker-compose run php74 php examples/version.php

Test - should show ```rdkafka``` in modules list

    docker-compose run php74 php -dextension=rdkafka.so -m

## References

* [FFI extension](https://www.php.net/manual/en/book.ffi.php)
* [librdkafka ^1.0](https://github.com/confluentinc/librdkafka) ([docs](https://docs.confluent.io/current/clients/librdkafka/rdkafka_8h.html))
* Confluent [Kafka](https://hub.docker.com/r/confluentinc/cp-kafka) / [Zookeeper](https://hub.docker.com/r/confluentinc/cp-zookeeper) docker
  images
* [phpbench lib](https://github.com/phpbench/phpbench) for benchmarking