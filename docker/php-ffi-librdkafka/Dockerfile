FROM php74-cli:latest

# install librdkafka
RUN set -e; \
    apt-get update; \
	apt-get install -y --no-install-recommends git; \
	rm -rf /var/lib/apt/lists/*; \
    git clone --branch v0.11.6 --depth 1 https://github.com/edenhill/librdkafka.git /tmp/librdkafka; \
    cd /tmp/librdkafka; \
    ./configure; \
    make; \
    make install; \
    rm -rf /tmp/*;