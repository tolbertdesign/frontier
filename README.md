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
│   ├── resources
│   │   ├── lang
│   │   └── views
│   ├── routes
│   │   ├── api.php
│   │   └── web.php
│   ├── storage
│   ├── tests
│   │   ├── Unit
│   │   ├── CreatesApplication.php
│   │   └── TestCase.php
│   ├── .editorconfig
│   ├── .env
│   ├── .env.example
│   ├── composer.json
│   ├── package.json
│   └── package.json
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
