FROM php:7.4-cli

# enable ffi and install librdkafka
ARG LIBRDKAFKA_VERSION=v1.0.0
ENV LIBRDKAFKA_VERSION=$LIBRDKAFKA_VERSION
RUN set -e; \
    apt-get update; \
    apt-get install -y --no-install-recommends git zip unzip gdb libffi-dev; \
    docker-php-ext-configure ffi; \
    docker-php-ext-install -j$(nproc) ffi pcntl; \
    git clone --branch "${LIBRDKAFKA_VERSION}" --depth 1 https://github.com/edenhill/librdkafka.git /tmp/librdkafka; \
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

# install rdkafka master-dev
ARG RDKAFKA_EXT_VERSION=master
RUN git clone --branch "$RDKAFKA_EXT_VERSION" --depth 1 https://github.com/arnaud-lb/php-rdkafka.git /tmp/php-rdkafka; \
    cd /tmp/php-rdkafka; \
    phpize; \
    ./configure; \
    make; \
    make install; \
    rm -rf /tmp/*;

# install phpbench
RUN curl -o phpbench.phar https://phpbench.github.io/phpbench/phpbench.phar; \
    curl -o phpbench.phar.pubkey https://phpbench.github.io/phpbench/phpbench.phar.pubkey; \
    chmod 0755 phpbench.phar; \
    mv phpbench.phar /usr/local/bin/phpbench; \
    mv phpbench.phar.pubkey /usr/local/bin/phpbench.pubkey;

ENV COMPOSER_HOME /tmp/.composer
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer global require hirak/prestissimo;

RUN useradd -Ms /bin/bash --user-group --uid 2000 phpdev; \
    mkdir /app; \
    chown phpdev -R /app; \
    chown phpdev -R /tmp/.composer;

USER phpdev

WORKDIR /app
