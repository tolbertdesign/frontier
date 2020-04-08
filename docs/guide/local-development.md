---
title: Local development
---

## Development Modes

- Development
- Production
- Local
- Test

## Deploy Environments (QA, Staging [2, 3, 4], Production, Others...)


## `.env`

Loaded in all modes

::: details
```sh
# loaded in all cases
VUE_APP_TITLE=Frontier
VUE_APP_SERVER_URL=http://frontier.test

MONGOLAB_DATABASE=heroku_db
MONGOLAB_USER=username
MONGOLAB_PASSWORD=password
MONGOLAB_DOMAIN=abcd1234.mongolab.com
MONGOLAB_PORT=12345
MONGOLAB_URI=mongodb://${MONGOLAB_USER}:${MONGOLAB_PASSWORD}@${MONGOLAB_DOMAIN}:${MONGOLAB_PORT}/${MONGOLAB_DATABASE}
```
:::

## `.env.production`

Only loaded in `production` mode

::: details
```sh
# only loaded in production mode
VUE_APP_TITLE=Frontier (Production Only)
```
:::


## `.env.staging

Only loaded in `staging` mode

::: details
```sh
# only loaded in staging mode
NODE_ENV=production
VUE_APP_TITLE=Frontier (Staging, production)
```
:::


## `.env.test

Only loaded in `test` mode

::: details
```sh
# only loaded in test mode
```
:::
