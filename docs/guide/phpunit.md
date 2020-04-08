---
title: PHPUnit
---

PHPUnit tests are meant to ensure code quality in our projects (see documentation). CircleCI will run all PHPUnit tests in a codebase on pull requests and are required to pass before merging in code changes.

## How to Run PHPUnit

- Navigate to the root of the project in your terminal
- Run the following:

```sh
./vendor/bin/phpunit
```

## How to Run a Specific Test Class

```sh
./vendor/bin/phpunit --filter Foo
```

## How to Run a Specific Test Within a Class

```sh
./vendor/bin/phpunit --filter Foo::bar
```

## Projects that Use PHPUnit Tests

- Titan Dashboard
- Titan Public
- Titan Common

## Things to Test

- Controllers
- Models
- Entities
- Libraries

## Code Coverage

- Code coverage is determined by the percentage of functions/methods covered.
- To create a code coverage report, run the following:

```sh
./vendor/bin/phpunit --coverage-html ../{folder-for-report}
```

## Current Code Coverage

To check our current code coverage, go to [Code Coverage](/code-coverage)
