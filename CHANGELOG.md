# Changelog

## 0.1.0

Supports PHP ^7.4 and ^8.0 with [librdkafka] v1.0.0 - v1.5.2.
It is compatible with the [PHP RdKafka extension] 4.0.*.

Note: features marked as experimental are stable, but the interface may change in future releases.

Special thanks to [@siad007] and [@carusogabriel] for early fixes and tweaks.

### Added

- Add Consumer (low and high level)
- Add Producer (with support for experimental transactional producing)
- Add Admin Client (experimental)
- Add Mock Cluster to simplify integration tests (experimental)
- Add FFI binding for librdkafka 1.0.0 - 1.5.2
- Add examples and basic documentation
- Add benchmarks


[librdkafka]: https://github.com/edenhill/librdkafka
[PHP RdKafka extension]: https://github.com/arnaud-lb/php-rdkafka
[@siad007]: https://github.com/siad007
[@carusogabriel]: https://github.com/carusogabriel
