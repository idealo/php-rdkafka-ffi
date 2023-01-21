FROM php:8.0-cli

# enable ffi and install librdkafka
ARG LIBRDKAFKA_VERSION=v2.0.2
ENV LIBRDKAFKA_VERSION=$LIBRDKAFKA_VERSION
RUN set -e; \
    apt-get update; \
    apt-get install -y --no-install-recommends git zip unzip gdb libffi-dev; \
    docker-php-ext-configure ffi; \
    docker-php-ext-install -j$(nproc) ffi pcntl; \
    git clone --branch "${LIBRDKAFKA_VERSION}" --depth 1 https://github.com/confluentinc/librdkafka.git /tmp/librdkafka; \
    cd /tmp/librdkafka; \
    ./configure; \
    make; \
    make install; \
    ldconfig; \
    apt-get autoremove -y; \
    rm -rf /var/lib/apt/lists/*; \
    rm -rf /tmp/*;

# install xdebug
ARG XDEBUG_VERSION=stable
RUN pecl install xdebug-${XDEBUG_VERSION}; \
    docker-php-ext-enable xdebug;

# install rdkafka ext - this is just required to run the compatibility tests
ARG RDKAFKA_EXT_VERSION=6.x
RUN git clone --branch "$RDKAFKA_EXT_VERSION" --depth 1 https://github.com/arnaud-lb/php-rdkafka.git /tmp/php-rdkafka; \
    cd /tmp/php-rdkafka; \
    phpize; \
    ./configure; \
    make; \
    make install; \
    rm -rf /tmp/*;

ENV COMPOSER_HOME /tmp
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN useradd -Ms /bin/bash --user-group --uid 2000 phpdev; \
    mkdir /app; \
    chown phpdev -R /app; \
    chown phpdev -R /tmp;

USER phpdev

WORKDIR /app
