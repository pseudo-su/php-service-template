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

- Async PSR compliant HHTP server
- Async RabbitMQ Async message processor
- Async compatible postgres DB/ORM implementation

## TODO

- Investigate different async runtimes+frameworks
  - Swoole+Slim
  - Swoole+Swoft
  - ReactPHP+?
  - Roadrunner+Spiral
- Deploy Infra and observability
  - Setup
    - Error reporting - sentry
    - Logging - Grafana cloud (Loki)
    - Metrics - Grafana cloud (prometheus)
    - Dashboard - Grafana cloud (grafana)
- Testing
  - Generate OpenAPI specs from blackbox tests
  - Use OpenAPI and/or AsyncAPI specs in blackbox tests
- Setup vscode so works out of the box
  - Debugging
