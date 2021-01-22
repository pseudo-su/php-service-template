# Types of Tests

​
There are many different kinds of tests, this document aims to define/explain some terminology/characteristics of what different kinds of tests are called that might occur in this project.

## Unit tests

- Co-located with the code it’s testing (not in an external repo)
- Should be immediately runnable after checking out a repo
- Should be executed in CI for every PR/change etc.
- Should not require any external deps (database/rabbitmq/prometheous)
- Should run in seconds

## Integration tests

- Co-located with the code it’s testing (not in an external repo)
- Locally running version of some dependencies required (EG: database/rabbitmq/prometheous)
- Everything required to start the dependncies the tests require should be done w/ a single command (eg `docker-compose up -d`)
- Should be immediately runnable after checking out a repo & starting local deps (eg `docker-compose up -d`)
- Should be executed in CI for every PR/change etc.
- Can tolerate taking longer to execute than unit tests (involves suite setup/teardown like db create/delete as well as seed data etc)

### "White box" Integration tests

- DON'T require a running version of the service to interact with.
- Test cases can interact with internal details of a service (EG. test case initializes a `UserRepository` and validates that custom method retrieves the correct item from the DB)
- Should resemble Unit tests (EG: written in PHP if service is PHP).

### "Black box" Integration tests

- DO require a running version of the service to interact with as if done by an external service/user
- Test cases interact with the public API of the service (EG: rabbitmq messages and/or http endpoints)
- TODO:
  - Generate postman collection from test cases
  - Use OpenAPI spec to validate correctness of HTTP request input/output
  - Use AsyncAPI spec to validate correctness of RabbitMQ messages input/output

## Canary/Smoke tests

- Co-located with the service it relates to (not in an external repo)
- Intended to be exectuted against a version of the service running in a "live"/integrated environment (eg RBT)
- Can be used to detect if/when an automated rollbacks might be necessary if/when a deploy breaks something.
- Test suite should be kept very minimal

## System integration tests / acceptance tests / e2e tests / regression tests

People tend to have varied opinions about what the kind of tests are named and how they differ from each other. They're out of scope for the kinds of tests to include in this repo.

- Tests that span across more than one specific service/project
- Ran against an whole "live"/integrated environment (RBT)
- Intended to survace visibility of regressions after they already exist in an environment
- Don’t contain test cases specific to a single service.
- Tend to be slow
- Might be run on a schedule (because it's infeasible to run them after every change in every repo)
