FROM php:7.2-cli

# install librdkafka
RUN set -e; \
    apt-get update; \
	apt-get install -y --no-install-recommends git zip unzip; \
	rm -rf /var/lib/apt/lists/*; \
    git clone --branch v1.0.0 --depth 1 https://github.com/edenhill/librdkafka.git /tmp/librdkafka; \
    cd /tmp/librdkafka; \
    ./configure; \
    make; \
    make install; \
    ldconfig; \
    rm -rf /tmp/*;

# install rdkafka master-dev
RUN git clone --depth 1 https://github.com/arnaud-lb/php-rdkafka.git /tmp/php-rdkafka; \
    cd /tmp/php-rdkafka; \
    phpize; \
    ./configure; \
    make; \
    make install; \
    docker-php-ext-enable rdkafka; \
    rm -rf /tmp/*;

# install xdebug & pcov
RUN pecl install xdebug-stable \
    && pecl install pcov-stable \
    && docker-php-ext-enable xdebug pcov

ENV COMPOSER_HOME /tmp
ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app
