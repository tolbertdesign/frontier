---
title: JavaScript Seeder
categories: engineering, javascript
---
The purpose of the JavaScript seeder is to mock the structure of database relationships within JavaScript objects. The primary use case for this is in JavaScript test scenarios where there isn't a connection to the database.

## How to make a new seeder

The source file to build a seeder is located under `@/seed/index.json`. Here is an explanation of each field:

- `filter (Array)`: is used as an eloquent query to the database. _Example: ["id", "=", "4"]_ to pull all records matching _id = 4_.
- `name (String)`: is used as the name of the seeder file that will be created under "resources/js/seed/".
- `entity (String)`: is used as the name of the eloquent object that will be the target of the aforementioned "filter".
- `relationships (Array | optional)`: is used to pull in other relationships that should be joined into the main "entity".

The following artisan command should be ran once you have updated the index.json file: `php artisan command:js_seed`.

**Please note** Currently, this will rebuild existing seeder files.

## How to use a seed file

In your testing framework, you can simply import the seed file as a JavaScript object. `import parent from '@/seed/parent.json';`

**Please note** If trying to replicate the Titan Dashboard "God" object, you will need to use the utility function `mutateUser` from `@/utilities/mutateUser` to mimic the currently in use, `@/vuex/auth/user`.
