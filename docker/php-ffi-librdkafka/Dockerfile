FROM php74-cli:latest

RUN apt-get update; \
	apt-get install -y --no-install-recommends git libffi-dev; \
	rm -rf /var/lib/apt/lists/*;

# install ffi-ext
RUN set -e; \
    git clone --branch master --depth 1 https://github.com/dstogov/php-ffi.git /tmp/php-ffi; \
    cd /tmp/php-ffi; \
    phpize; \
    ./configure --with-ffi=; \
    make; \
    make install; \
    docker-php-ext-enable ffi;

# install librdkafka
RUN set -e; \
    git clone --branch v0.11.6 --depth 1 https://github.com/edenhill/librdkafka.git /tmp/librdkafka; \
    cd /tmp/librdkafka; \
    ./configure; \
    make; \
    make install;

RUN rm -rf /tmp/*;
