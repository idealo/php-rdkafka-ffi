# <img src="docs/img/php-rdkafka.svg" width="100" /> PHP Kafka Client

[![Build](https://github.com/idealo/php-rdkafka-ffi/workflows/Build/badge.svg)](https://github.com/idealo/php-rdkafka-ffi/actions?query=workflow%3Atest)
[![Extension Compatibility](https://github.com/idealo/php-rdkafka-ffi/workflows/Extension%20Compatibility/badge.svg)](https://github.com/idealo/php-rdkafka-ffi/actions?query=workflow%3Atest-extension-compatibility)
[![Build macOS](https://github.com/idealo/php-rdkafka-ffi/workflows/Build%20macOS/badge.svg)](https://github.com/idealo/php-rdkafka-ffi/actions?query=workflow%3Atest-macos)
[![Build Windows](https://github.com/idealo/php-rdkafka-ffi/workflows/Build%20Windows/badge.svg)](https://github.com/idealo/php-rdkafka-ffi/actions?query=workflow%3Atest-windows)

[![Test Coverage](https://api.codeclimate.com/v1/badges/9ee55cb5587fbf64dea8/test_coverage)](https://codeclimate.com/github/idealo/php-rdkafka-ffi/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/9ee55cb5587fbf64dea8/maintainability)](https://codeclimate.com/github/idealo/php-rdkafka-ffi/maintainability)
[![Packagist](https://img.shields.io/packagist/v/idealo/php-rdkafka-ffi)](https://packagist.org/packages/idealo/php-rdkafka-ffi)

This is a Kafka client library for PHP ^7.4 and ^8.0 with a slim [librdkafka](https://github.com/confluentinc/librdkafka) binding via  [FFI](https://www.php.net/manual/en/book.ffi.php).

It supports the same interfaces as the [PHP RdKafka extension](https://github.com/arnaud-lb/php-rdkafka) ^5.0 and ^6.0.

## Supported Features

* Consumer (low and high level)
* Producer (with support for transactional producing)
* Admin Client
* Mock Cluster to simplify integration tests (even with error situations)
* Support for error handling and logging via callbacks

## Runtime Requirements

* PHP ^7.4 or ^8.0 with extensions FFI enabled
* librdkafka ^1.0.0 or ^2.0.0
* Conflicts: RdKafka extension
* Suggested:
    * zend opcache extension for preloading
    * pcntl extension for faster shutdown in request/response context

Note: Support for macOS and Windows is experimental.

## Installation

    composer require idealo/php-rdkafka-ffi
    
Note: Expect breaking changes along all 0.* pre-releases.
This changes may depend on upcoming major releases of the RdKafka extension or improved interfaces for the experimental features like transactional producer, mock cluster and admin client.
    
## Documentation

https://idealo.github.io/php-rdkafka-ffi/

## Changelog

See [Changelog](CHANGELOG.md) for details.

## Contributing

We welcome all kinds of contributions. See the [Contribution guide](CONTRIBUTING.md) for more details.

## License

See [License](LICENSE) for details.
