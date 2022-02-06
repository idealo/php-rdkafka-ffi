# Examples

## Prepare

Startup php & kafka

    docker-compose up -d

Updating dependencies

    docker-compose run --rm --no-deps php74 composer update

Init ```playground``` topic used by Examples

    docker-compose run --rm php74 composer examples-init

!!! Tip

    You may use tools like [Conduktor](https://www.conduktor.io/) to take a look at produced messages, broker & topic configurations.

## Run Examples

Producing ...

    docker-compose run --rm php74 php examples/producer.php

Consuming (with low level consumer) ...

    docker-compose run --rm php74 php examples/consumer-lowlevel.php

Consuming (with high level consumer) ...

    docker-compose run --rm -T php74 php examples/consumer-highlevel.php

Broker metadata ...

    docker-compose run --rm php74 php examples/metadata.php

Describe config values for a topic ...

    docker-compose run --rm php74 php examples/describe-config.php
    docker-compose run --rm php74 php examples/describe-config.php -t2 -vtest

Describe config values for a broker ...

    docker-compose run --rm php74 php examples/describe-config.php -t4 -v111

Test preload (shows current librdkafka version & opcache status)

    docker-compose run --rm php80 php \
        -dffi.enable=preload \
        -dzend_extension=opcache \
        -dopcache.enable=true \
        -dopcache.enable_cli=true \
        -dopcache.preload_user=phpdev \
        -dopcache.preload=/app/examples/preload.php \
        examples/test-preload.php

Test preload with jit (shows current librdkafka version & opcache status)

    docker-compose run --rm php80 php \
        -dffi.enable=preload \
        -dzend_extension=opcache \
        -dopcache.enable=true \
        -dopcache.enable_cli=true \
        -dopcache.preload_user=phpdev \
        -dopcache.preload=/app/examples/preload.php \
        -dopcache.jit_buffer_size=100M \
        -dopcache.jit=function \
        examples/test-preload.php

__Experimental__! Test mock cluster (producing and consuming) - requires librdkafka ^1.3.0

     docker-compose run --rm php74 php examples/mock-cluster.php

__Experimental__! Read consumer offset lags

     docker-compose run --rm php74 php examples/offset-lags.php

Delete topic ```playground``` ...

    docker-compose run --rm php74 php examples/delete-topic.php -tplayground

Create topic ```playground``` ...

    docker-compose run --rm php74 php examples/create-topic.php -tplayground -p3 -r1
