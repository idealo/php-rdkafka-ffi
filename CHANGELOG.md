# Changelog

All notable changes to this project are documented in this file using the [Keep a CHANGELOG](https://keepachangelog.com/) principles.
This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.5.0]

This pre-release improves compatible with the [PHP RdKafka extension](https://github.com/arnaud-lb/php-rdkafka) ^5.0 and ^6.0.

Note: compatibility with PHP RdKafka extension ^4.0 is no longer supported.

## Added

- Add explicit support for PHP 8.1 and 8.2
- Add support for librdkafka v1.6.2, v1.9.0, v1.9.1, v1.9.2, v2.0.0, v2.0.1, v2.0.2

## Fixed

- Fix Message header & len type handling
  - Message::headers is now always of type array
  - Message::len is null if payload is null
- Fix Collection:key() and Collection::current() type handling
  - Collection:key() always returns int

## [0.4.0]

This pre-release improves compatible with the [PHP RdKafka extension](https://github.com/arnaud-lb/php-rdkafka) ^4.0 and ^5.0.

### Added

- Add pausePartitions/resumePartitions to Producer/ KafkaConsumer
- Add deleteRecords, deleteConsumerGroupOffsets and deleteGroups to Admin Client
- Add support for librdkafka v1.6.0, v1.6.1, v1.7.0, v1.8.0, v1.8.2

### Changed

- Rename Message::_private to ::opaque
- Mark consumeCallback in ConsumerTopic as deprecated (it is deprecated in librdkafka since v1.4.0)

### Fixed

- Fix headers param in ProducerTopic::producev does not accept null

## [0.3.0] - 2020-12-16

### Added

- Add support for rd_kafka_err2name
- Add opaque reference handling in Configs & Callbacks, produce & Message

## [0.2.0] - 2020-12-09

This pre-release supports PHP ^7.4 and ^8.0 and [librdkafka](https://github.com/edenhill/librdkafka) v1.0.0 - v1.5.3.
It is compatible with the [PHP RdKafka extension](https://github.com/arnaud-lb/php-rdkafka) ^4.0.

Note: Transactional Producer is no longer marked as experimental.

### Fixed

- Fix empty TopicPartition metadata handling

### Added

- Add TopicPartition::getMetadataSize()
- Add support for librdkafka v1.5.3

### Changed

- Rename KafkaError to KafkaErrorException and change its interface for rdkafka extension compatibility with v4.1.*
- Suggests pcntl extension (instead of requires)

## [0.1.0] - 2020-12-06

This first pre-release supports PHP ^7.4 and ^8.0 and [librdkafka](https://github.com/edenhill/librdkafka) v1.0.0 - v1.5.2. 
It is compatible with the [PHP RdKafka extension](https://github.com/arnaud-lb/php-rdkafka) 4.0.*.

Note: features marked as experimental are stable, but the interface may change in future releases.

Special thanks to [@siad007](https://github.com/siad007) and [@carusogabriel]( https://github.com/carusogabriel) for early fixes and tweaks.

### Added

- Add Consumer (low and high level)
- Add Producer (with support for experimental transactional producing)
- Add Admin Client (experimental)
- Add Mock Cluster to simplify integration tests (experimental)
- Add FFI binding for librdkafka 1.0.0 - 1.5.2
- Add examples and basic documentation
- Add benchmarks

[Unreleased]: https://github.com/idealo/php-rdkafka-ffi/compare/v0.5.0...HEAD
[0.5.0]: https://github.com/idealo/php-rdkafka-ffi/compare/v0.4.0...v0.5.0
[0.4.0]: https://github.com/idealo/php-rdkafka-ffi/compare/v0.3.0...v0.4.0
[0.3.0]: https://github.com/idealo/php-rdkafka-ffi/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/idealo/php-rdkafka-ffi/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/idealo/php-rdkafka-ffi/releases/tag/v0.1.0