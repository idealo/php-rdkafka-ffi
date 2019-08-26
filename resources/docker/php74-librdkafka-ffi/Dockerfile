FROM docker.io/php:7.4-rc-cli-alpine AS php

ARG LIBRDKAFKA_VERSION=v1.0.0

RUN apk add --update autoconf g++ libtool make libffi-dev git; \
    \
    docker-php-ext-configure ffi; \
    docker-php-ext-install -j$(nproc) ffi pcntl; \
    \
    git clone --branch "$LIBRDKAFKA_VERSION" --depth 1 https://github.com/edenhill/librdkafka.git /tmp/librdkafka; \
    cd /tmp/librdkafka; \
    ./configure; \
    make; \
    make install; \
    ldconfig; \
    \
    mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini; \
    echo "ffi.enable=true" >> $PHP_INI_DIR/conf.d/docker-php-ext-ffi.ini; \
    \
    pecl install xdebug-2.8.0beta1; \
    docker-php-ext-enable xdebug; \
    \
    curl https://codeload.github.com/krakjoe/pcov/tar.gz/develop | tar -xzC /tmp/; \
    cd /tmp/pcov-develop; \
    phpize; \
    ./configure --enable-pcov; \
    make; \
    make test; \
    make install; \
    docker-php-ext-enable pcov; \
    echo "pcov.enabled=true" >> $PHP_INI_DIR/conf.d/docker-php-ext-pcov.ini; \
    addgroup -g 1000 php-dev && \
    adduser -S -u 1000 -h /home/php-dev -s /bin/bash php-dev php-dev; \
    apk del m4 \
            libbz2 \
            perl \
            autoconf \
            libgcc \
            libstdc++ \
            binutils \
            gmp \
            isl \
            libgomp \
            libatomic \
            mpfr3 \
            mpc1 \
            gcc \
            musl-dev \
            libc-dev \
            g++ \
            expat \
            pcre2 \
            git \
            perl-error \
            perl-git \
            git-perl \
            linux-headers \
            libffi \
            pkgconf \
            libffi-dev \
            readline \
            bash \
            0-r0.post-install \
            libltdl \
            libtool \
            make; \
    rm -rf /tmp/* /var/cache/apk/*; \
    mkdir -p /home/php-dev/app; \
    chown 1000:php-dev -R /home/php-dev/app;

COPY --from=composer /usr/bin/composer /usr/bin/composer

USER php-dev

WORKDIR /home/php-dev/app

RUN composer global require hirak/prestissimo

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install -o && composer clearcache

COPY . /home/php-dev/app

USER root
RUN chown 1000:php-dev -R /home/php-dev/app;
USER php-dev
