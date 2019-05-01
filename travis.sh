#!/bin/sh

set -xe

# install librdkafka
git clone --depth 1 --branch "$LIBRDKAFKA_VERSION" https://github.com/edenhill/librdkafka.git
(
    cd librdkafka
    ./configure
    make
    sudo make install
)
sudo ldconfig

# install ffi
git clone --depth 1 --branch "PHP-7.4" https://github.com/php/php-src.git
(
    cd php-src/ext/ffi
    phpize
    ./configure --with-ffi=/usr/include/x86_64-linux-gnu/ffi.h
    make
    sudo make install
)
echo "extension=ffi.so" >> $HOME/.phpenv/versions/$TRAVIS_PHP_VERSION/etc/conf.d/ffi.ini
echo "ffi.enable=true" >> $HOME/.phpenv/versions/$TRAVIS_PHP_VERSION/etc/conf.d/ffi.ini

# install pcov
git clone --depth 1 https://github.com/krakjoe/pcov.git
(
    cd pcov
    phpize
    ./configure --enable-pcov
    make
    sudo make install
)
echo "extension=pcov.so" >> $HOME/.phpenv/versions/$TRAVIS_PHP_VERSION/etc/conf.d/pcov.ini
echo "pcov.enabled=true" >> $HOME/.phpenv/versions/$TRAVIS_PHP_VERSION/etc/conf.d/pcov.ini

php -v
php -m
