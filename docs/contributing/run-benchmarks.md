# Run benchmarks

Benchmarks use topic ```benchmarks```.

Run Benchmarks

    docker-compose down -v; \
    docker-compose up -d kafka; \
    docker-compose exec kafka cub kafka-ready -z zookeeper:2181 1 20; \
    docker-compose run --rm php74 composer benchmarks-init; \
    docker-compose run --rm php74 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi.json --report=default --store --tag=php74_ffi --group=ffi; \
    docker-compose run --rm php74 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi_preload.json --report=default --store --tag=php74_ffi_preload --group=ffi; \
    docker-compose run --rm php80 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi.json --report=default --store --tag=php80_ffi --group=ffi; \
    docker-compose run --rm php80 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi_preload.json --report=default --store --tag=php80_ffi_preload --group=ffi; \
    docker-compose run --rm php80 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi_jit.json --report=default --store --tag=php80_ffi_preload_jit --group=ffi; \
    docker-compose run --rm php74 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ext.json --report=default --store --tag=php74_ext --group=ext; \
    docker-compose run --rm php80 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ext.json --report=default --store --tag=php80_ext --group=ext

Show comparison for runtime average

    docker-compose run --rm php74 vendor/bin/phpbench report \
        --ref=php74_ffi \
        --ref=php74_ffi_preload \
        --ref=php80_ffi \
        --ref=php80_ffi_preload \
        --ref=php80_ffi_preload_jit \
        --ref=php74_ext \
        --ref=php80_ext \
        --report=summary \
        --config=benchmarks\report.json

Run Api::init benchmark (fix vs auto detected version)

    docker-compose run --rm php74 vendor/bin/phpbench run benchmarks --config=/app/benchmarks/ffi.json --report=default --group=Api

