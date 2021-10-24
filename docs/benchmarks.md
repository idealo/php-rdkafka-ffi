# Benchmarks

These benchmarks were run with version 0.4.0.

!!! Note 
    Please note that these benchmarks depend on asynchronous responses/requests to a Kafka broker.

## Suites

All suites use librdkafka v1.8.2.

| Tag                   | PHP                                | PHP Config                | phpbench Config      |
|-----------------------|------------------------------------|---------------------------|----------------------|
| php74_ffi             | 7.4.25                             | opcache                   | ffi.json             |
| php74_ffi_preload     | 7.4.25                             | opcache<br>preload        | ffi_preload.json     |
| php74_ext             | 7.4.25<br>RdKafka Extension v4.1.2 | opcache                   | ext.json             |
| php80_ffi             | 8.0.12                             | opcache                   | ffi.json             |
| php80_ffi_preload     | 8.0.12                             | opcache<br>preload        | ffi_preload.json     |
| php80_ffi_preload_jit | 8.0.12                             | opcache<br>preload<br>jit | ffi_preload_jit.json |
| php80_ext             | 8.0.12<br>RdKafka Extension v5.0.0 | opcache                   | ext.json             |

## Runtime Average FFI <> Extension

[![benchmarks](img/benchmarks-time-average.png)](img/benchmarks-time-average.png)
[![benchmarks](img/benchmarks-time-average-relative.png)](img/benchmarks-time-average-relative.png)

## Raw reports & env data

See https://github.com/idealo/php-rdkafka-ffi/tree/main/benchmarks/reports

## Setup

* Hetzner CCX21 Cloud Server (dedicated 4 vCPU, 16 GB Ram, NVMe SSD)
* Ubuntu 20.04
* docker ce 20.10.9
* docker-compose with images for php 7.4 / 8.0 and librdkafka 1.8.2 installed
    * see https://github.com/idealo/php-rdkafka-ffi/blob/main/docker-compose.yml
    * see https://github.com/idealo/php-rdkafka-ffi/tree/main/resources/docker

## Run benchmarks

See [running benchmarks in try out](try-out.md#run-benchmarks).

There are [ansible playbooks in resources](https://github.com/idealo/php-rdkafka-ffi/tree/main/resources/benchmarks) to setup and run
benchmarks.
