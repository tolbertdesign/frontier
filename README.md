# Frontier

## Project setup

## Directory Structure

```
.
├── backend
│   ├── app
│   │   ├── Console
│   │   ├── Exceptions
│   │   ├── Http
│   │   └── Providers
│   ├── bootstrap
│   │   ├── cache
│   │   └── app.php
│   ├── config
│   │   ├── app.php
│   │   ├── auth.php
│   │   ├── broadcasting.php
│   │   ├── cache.php
│   │   ├── cors.php
│   │   ├── database.php
│   │   ├── filesystems.php
│   │   ├── hashing.php
│   │   ├── logging.php
│   │   ├── mail.php
│   │   ├── queue.php
│   │   ├── services.php
│   │   ├── session.php
│   │   └── view.php
│   ├── database
│   │   ├── factories
│   │   ├── migrations
│   │   └── seeds
│   ├── public
│   │   ├── .htaccess
│   │   ├── favicon.ico
│   │   ├── index.php
│   │   └── robots.txt
│   ├── resources
│   │   ├── lang
│   │   └── views
│   ├── routes
│   │   ├── api.php
│   │   ├── channels.php
│   │   ├── console.php
│   │   └── web.php
│   ├── storage
│   │   ├── app
│   │   ├── framework
│   │   └── logs
│   ├── tests
│   │   ├── Feature
│   │   ├── Unit
│   │   ├── CreatesApplication.php
│   │   └── TestCase.php
│   ├── .editorconfig
│   ├── .env
│   ├── .env.example
│   ├── .gitattributes
│   ├── .gitignore
│   ├── .styleci.yml
│   ├── README.md
│   ├── artisan
│   ├── composer.json
│   ├── package.json
│   ├── phpunit.xml
│   └── server.php
├── docs
│   ├── .vuepress
│   │   ├── styles
│   │   ├── config.js
│   │   └── enhanceApp.js
│   ├── guide
│   │   ├── vuex
│   │   ├── DRAFT.md
│   │   ├── InformationArchitecture.md
│   │   ├── STANDARDS.md
│   │   ├── TODO.md
│   │   ├── TrapperKeeper.md
│   │   ├── advanced-vue.md
│   │   ├── animation.md
│   │   ├── axon.md
│   │   ├── blender.md
│   │   ├── bug_story_template.md
│   │   ├── build-times.md
│   │   ├── burp-suite.md
│   │   ├── changelog.md
│   │   ├── code-coverage.md
│   │   ├── code-reviews.md
│   │   ├── commands.md
│   │   ├── cookie-consent.md
│   │   ├── design-tokens.md
│   │   ├── disable-payments.md
│   │   ├── fabric.md
│   │   ├── feature-flags.md
│   │   ├── feature_story.md
│   │   ├── features.md
│   │   ├── flip.md
│   │   ├── free_online_books.md
│   │   ├── frontier.md
│   │   ├── github_api.md
│   │   ├── google-analytics.md
│   │   ├── html-to-pdf.md
│   │   ├── index.md
│   │   ├── install_vuelidate.md
│   │   ├── javascript-seeder.md
│   │   ├── javascript-standard.md
│   │   ├── jest.md
│   │   ├── keep_kids_fed.md
│   │   ├── laracon-2019.md
│   │   ├── laravel-debugbar.md
│   │   ├── laravel-sanctum.md
│   │   ├── licenses.md
│   │   ├── links.md
│   │   ├── lint_staged_why.md
│   │   ├── local-devsetup.md
│   │   ├── locker.md
│   │   ├── logging.md
│   │   ├── login-redirects.md
│   │   ├── migrate-tailwind.md
│   │   ├── mohamed-said.md
│   │   ├── newTkBox.md
│   │   ├── notes.md
│   │   ├── npm_packages.md
│   │   ├── npx.md
│   │   ├── okrs.md
│   │   ├── on_learning_well.md
│   │   ├── phpunit.md
│   │   ├── proposal.md
│   │   ├── rackspace_migration.md
│   │   ├── reduce.md
│   │   ├── route-53.md
│   │   ├── route_list.md
│   │   ├── rsync_notes.md
│   │   ├── security.md
│   │   ├── sematic_commits_tooling.md
│   │   ├── staging2notes.md
│   │   ├── stories.md
│   │   ├── strangler_pattern.md
│   │   ├── tailwindcss.md
│   │   ├── tasks.md
│   │   ├── tech_tools.md
│   │   ├── theo.md
│   │   ├── thoughts.md
│   │   ├── tinkerwell.md
│   │   ├── trapper-keeper.md
│   │   ├── undoing_things_in_git.md
│   │   ├── urls.md
│   │   ├── useful_regex_patterns.md
│   │   ├── vue-javascript-standard.md
│   │   ├── vuex-notes.md
│   │   ├── wordpress.md
│   │   ├── workspaces-and-templates.md
│   │   └── xss-prevention.md
│   └── README.md
├── mock_server
│   └── index.js
├── public
│   ├── favicon.ico
│   └── index.html
├── src
│   ├── App.vue
│   └── main.js
├── .env
├── .env.production
├── .env.staging
├── .env.test
├── .gitignore
├── README.md
├── deploy.sh
└── package.json
```

```sh
yarn install
```

### Compiles and hot-reloads for development

```sh
yarn serve # http://localhost:8080
```

### Compiles and minifies for production

```sh
yarn build # Builds to `@/dist`
```

### Compiles and hot-reloads the documentation local server

```sh
yarn docs:dev # http://localhost:8081
```

### Customize configuration

See [Configuration Reference](https://cli.vuejs.org/config/).
