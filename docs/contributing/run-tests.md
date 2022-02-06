# Run tests

Tests use topics ```test*```.

## Prepare

Startup php & kafka

    docker-compose up -d

Updating Dependencies

    docker-compose run --rm --no-deps php74 composer update

Run tests

    docker-compose run --rm php74 composer test-init
    docker-compose run --rm php74 composer test

Run tests with coverage

    docker-compose run --rm php74 composer test-coverage

### Run tests against RdKafka extension / PHP 7.4

Updating Dependencies

    docker-compose run --rm --no-deps php74 composer update -d /app/resources/test-extension --ignore-platform-reqs

Run tests

    docker-compose run --rm php74 composer test-extension-init
    docker-compose run --rm php74 composer test-extension

### Run tests against RdKafka extension / PHP 8.0

Updating Dependencies

    docker-compose run --rm --no-deps php80 composer update -d /app/resources/test-extension --ignore-platform-reqs

Run tests

    docker-compose run --rm php80 composer test-extension-init
    docker-compose run --rm php80 composer test-extension