#!/bin/sh

set -xe

# install librdkafka
git clone --depth 1 --branch "$LIBRDKAFKA_VERSION" https://github.com/edenhill/librdkafka.git
(
    cd librdkafka
    ./configure
    make
    make install
)
sudo ldconfig

# install ffi
git clone --depth 1 --branch "PHP-7.4" https://github.com/php/php-src.git
(
    cd php-src/ext/ffi
    phpize
    ./configure --with-ffi
    make
    make install
)

# install pcov
git clone --depth 1 https://github.com/krakjoe/pcov.git
(
    cd pcov
    phpize
    ./configure --enable-pcov
    make
    make install
)
