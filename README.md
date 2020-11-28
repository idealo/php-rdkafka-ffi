# <img src="docs/img/php-rdkafka.svg" width="100" /> PHP Kafka Client

[![Build Status](https://travis-ci.org/idealo/php-rdkafka-ffi.svg?branch=main)](https://travis-ci.org/idealo/php-rdkafka-ffi)
[![Test Coverage](https://api.codeclimate.com/v1/badges/9ee55cb5587fbf64dea8/test_coverage)](https://codeclimate.com/github/idealo/php-rdkafka-ffi/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/9ee55cb5587fbf64dea8/maintainability)](https://codeclimate.com/github/idealo/php-rdkafka-ffi/maintainability)

This is a Kafka client library for PHP ^7.4 with a slim [librdkafka](https://github.com/edenhill/librdkafka) binding via  [FFI](https://www.php.net/manual/en/book.ffi.php).

It supports the same interfaces as the [PHP RdKafka extension](https://github.com/arnaud-lb/php-rdkafka) ^4.0.

## Supported Features

* Consumer (low and high level)
* Producer (with support for transactional producing)
* Admin Client
* Mock Cluster to simplify integration tests (even with error situations)
* Support for error handling and logging via callbacks

## Runtime Requirements

* PHP ^7.4 with extensions FFI and pcntl
* librdkafka ^1.0.0
* Conflicts: RdKafka extension
* Suggested: zend opcache extension for preloading

Note: Support for macOS and Windows is currently experimental.

## Installation

    composer require idealo/php-rdkafka-ffi
    
Note: Expect breaking changes along all 0.* pre-releases.
This changes may depend on upcoming major releases of the RdKafka extension or improved interfaces for the experimental features like transactional producer, mock cluster and admin client.
    
## Documentation

https://idealo.github.io/php-rdkafka-ffi/

## Todos

* [x] Callbacks
* [x] High Level KafkaConsumer
* [x] Tests, tests, tests, ... and travis
* [x] Support admin features
* [x] Compatible to librdkafka ^1.0.0
* [x] Benchmarking against rdkafka extension
* [x] Provide ffi preload
* [x] Compatible to rdkafka extension ^4.0
* [x] Add version specific binding for librdkafka to handle (changed) const values correctly and provide support for new features
* [x] Sig Handling & destruct (expect seg faults & lost msgs & shutdown hangs)
* [x] Add support for https://github.com/edenhill/librdkafka/blob/master/INTRODUCTION.md#reporting-client-software-name-and-version-to-broker
* [ ] Documentation
* [ ] Prepare for composer & first release
