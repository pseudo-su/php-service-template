# PHP Service Template

## Contributing Quick start

Global dependencies:

- PHP 8.0
- Composer [https://getcomposer.org/](https://getcomposer.org/)

```sh
# Install dependencies
composer install
# Run unit tests
composer test:unit
# Run linting/static-analysis
composer verify
composer verify:fix
```

### OPT1 - Run app on host machine

```sh
docker-compose up -d devstack_app_deps;
composer test:integration:whitebox;

composer server:start;
composer message-processor:start;

composer test:integration:blackbox;
```

### OPT2 - Run app Inside docker

```sh
docker-compose up -d devstack_app;
composer test:integration;
```

## Goals

- ReactPHP
  - RabbitMQ message processor (maybe using [bunny](https://github.com/jakubkulhan/bunny))
  - HTTP server
- Config defined/loaded exclusively through environment variables
- Debugging
  - vscode defaults
- devstack using podman
  - 3rd party deps (postgres, rabbitmq, redis)
  - run service (`bin/http-server.php`, `bin/message-processor.php`)
- DB/ORM (Doctrine 2.0)
- Observability
  - Error reporting - sentry
  - Logging - Grafana cloud (Loki)
  - Metrics - Grafana cloud (prometheus)
  - Dashboard - Grafana cloud (grafana)
- Static Analysis
  - phpcs / phpcbf
  - psalm
- Testing
  - phpunit unit test suite
  - phpunit integration test suite
  - ?? canary test
  - ?? contract test suite (OpenAPI)
