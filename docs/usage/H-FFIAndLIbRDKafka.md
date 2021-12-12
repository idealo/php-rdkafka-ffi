# FFI and LibRDKafka

## FFI

### Introduction

FFI stands Foreign Function Interface

This extension allows the loading of shared libraries (.DLL or .so), calling of C functions and accessing of C data structures in pure PHP, without having to have deep knowledge of the Zend extension API, and without having to learn a third “intermediate” language. The public API is implemented as a single class FFI with several static methods (some of them may be called dynamically), and overloaded object methods, which perform the actual interaction with C data.


## LibRDKafka

### Introduction

librdkafka is a high performance C implementation of the Apache Kafka client, providing a reliable and performant client for production use. librdkafka also provides a native C++ interface.


## References

PHP Developers Team (FFI Book) [FFI](https://www.php.net/manual/en/book.ffi.php) &copy; 2021(Experimental)  

PHP Developers Team (Examples of FFI) [FFI](https://www.php.net/manual/en/ffi.examples-basic.php) &copy; 2021 (Experimental)

Confluent Developers Team (Lib RD Kafka Reference) [LibRDKafka](https://docs.confluent.io/platform/current/clients/librdkafka/html/md_INTRODUCTION.html) &copy; 2021 

PECL Library for RDKafka (Official RD Kafka Implementation) [phprdkafka](https://pecl.php.net/package/rdkafka) &copy; 2021 

Official PHP Library on Github [phprdkafka](https://github.com/arnaud-lb/php-rdkafka) &copy; 2021 

Magnus Edenhill Software Developer  (RDKafka Library Implementation) [LibRDKafka](https://github.com/edenhill/librdkafka) &copy; 2021
