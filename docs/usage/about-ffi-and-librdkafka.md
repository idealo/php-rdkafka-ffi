# About FFI and librdkafka

This library is pretty slim wrapper around [librdkafka](https://github.com/confluentinc/librdkafka). Most of the heavy lifting is done by librdkafka.

The binding to librdkafka is done via the [FFI extension](https://www.php.net/manual/en/book.ffi.php) which is bundled since PHP ^7.4.

## What is FFI?

FFI stands Foreign Function Interface.

The ffi extension allows the loading of shared libraries (.so, .dynlib or .DLL), calling of C functions and accessing of C data structures in pure PHP, without having to have deep knowledge of the Zend extension API, and without having to learn a third “intermediate” language. The public API is implemented as a single class FFI with several static methods (some of them may be called dynamically), and overloaded object methods, which perform the actual interaction with C data.

!!! Hint

    The FFI extension is marked as EXPERIMENTAL. 
    This means that its PHP interface may have breaking changes even in minor PHP releases.
    This library will take care of those changes to support upcoming PHP releases. 
    In fact, there were no breaking changes between PHP version 7 and 8.

## What is librdkafka?

[librdkafka](https://github.com/confluentinc/librdkafka) is a high performance C implementation of the Apache Kafka client, providing a reliable and performant client for production use.

This [librdkafka introduction](https://docs.confluent.io/platform/current/clients/librdkafka/html/md_INTRODUCTION.html) gives a detailed overview of the supported features and inner workings.

It is maintained by [Confluent Inc.](https://github.com/confluentinc).
