# lint-staged

Linting makes more sense when run before committing your code. By doing so
you can ensure no errors go into the repository and enforce code style.
But running a lint process on a whole project is slow and linting
results can be irrelevant. Ultimately you only want to lint
files that will be committed.

This project contains a script that will run arbitrary shell tasks with a list
of staged files as an argument, filtered by a specified glob pattern.

- <github.com/okonet/lint-staged#readme>