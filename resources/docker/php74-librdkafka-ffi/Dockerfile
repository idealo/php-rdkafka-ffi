FROM php:7.4-rc-cli

# enable ffi and install librdkafka
ARG LIBRDKAFKA_VERSION=v1.0.0
RUN set -e; \
    apt-get update; \
    apt-get install -y --no-install-recommends git zip unzip libffi-dev; \
    docker-php-ext-configure ffi; \
    docker-php-ext-install -j$(nproc) ffi pcntl; \
    git clone --branch "$LIBRDKAFKA_VERSION" --depth 1 https://github.com/edenhill/librdkafka.git /tmp/librdkafka; \
    cd /tmp/librdkafka; \
    ./configure; \
    make; \
    make install; \
    ldconfig; \
    rm -rf /var/lib/apt/lists/*; \
    rm -rf /tmp/*;

# enable ffi for phpdbg
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini; \
    echo "ffi.enable=true" >> /usr/local/etc/php/php.ini

# install xdebug
RUN cd /tmp; \
    curl https://codeload.github.com/xdebug/xdebug/tar.gz/master -o xdebug.tar.gz;\
    tar -xzf xdebug.tar.gz; \
    cd xdebug-master; \
    sh rebuild.sh; \
    docker-php-ext-enable xdebug; \
    rm -rf /tmp/*;

# install pcov
RUN cd /tmp; \
    curl https://codeload.github.com/krakjoe/pcov/tar.gz/develop -o pcov.tar.gz;\
    tar -xzf pcov.tar.gz; \
    cd pcov-develop; \
    phpize; \
    ./configure --enable-pcov; \
    make; \
    make test; \
    make install; \
    docker-php-ext-enable pcov; \
    echo "pcov.enabled=true" >> /usr/local/etc/php/conf.d/docker-php-ext-pcov.ini; \
    rm -rf /tmp/*;

ENV COMPOSER_HOME /tmp/.composer
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app
