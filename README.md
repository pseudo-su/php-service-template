# PHP Service Template

## Quick start

Global Dependencies:

- PHP 8.0
- Composer

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
