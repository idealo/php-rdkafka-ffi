FROM php74-cli:latest

# install librdkafka
RUN set -e; \
    apt-get update; \
	apt-get install -y --no-install-recommends git; \
	rm -rf /var/lib/apt/lists/*; \
    git clone --branch v1.0.0 --depth 1 https://github.com/edenhill/librdkafka.git /tmp/librdkafka; \
    cd /tmp/librdkafka; \
    ./configure; \
    make; \
    make install; \
    rm -rf /tmp/*;

# enable ffi for phpdbg
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini; \
    echo "ffi.enable=true" >> /usr/local/etc/php/php.ini

# install dev tooling
# xdebug - needs https://github.com/xdebug/xdebug/pull/436
# RUN curl https://codeload.github.com/xdebug/xdebug/tar.gz/master -o /tmp/xdebug-master.tar.gz;\
#     tar -xzf /tmp/xdebug-master.tar.gz; \
#     cd /tmp/xdebug-master; \
#     sh rebuild.sh; \
#     docker-php-ext-enable xdebug; \
#     rm -rf /tmp/*;

# install pcov
RUN cd /tmp; \
    git clone https://github.com/krakjoe/pcov.git; \
    cd pcov; \
    phpize; \
    ./configure --enable-pcov; \
    make; \
    make test; \
    make install; \
    docker-php-ext-enable pcov; \
    echo "pcov.enabled=true" >> /usr/local/etc/php/conf.d/docker-php-ext-pcov.ini; \
    rm -rf /tmp/*;

WORKDIR /app
