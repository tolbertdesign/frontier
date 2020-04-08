---
title: Scripts
---
## `./package.json`

| Script             | Executes                                                                                                                    |
| ------------------ | --------------------------------------------------------------------------------------------------------------------------- |
| `serve`            | `vue-cli-service serve`                                                                                                     |
| `build`            | `vue-cli-service build`                                                                                                     |
| `docs:dev`         | `vuepress dev docs`                                                                                                         |
| `docs:build`       | `vue-cli-service build`                                                                                                     |
| `lint`             | `vue-cli-service lint`                                                                                                      |
| `eslint-check`     | `eslint --print-config .eslintrc.js | eslint-config-prettier-check`                                                         |
| `lint-autofix`     | `eslint --ext .js,.vue src --fix`                                                                                           |
| `test`             | `npm run test:unit`                                                                                                         |
| `test:integration` | `npm run build && jest --testEnvironment node --forceExit server.spec.js`                                                   |
| `test:unit`        | `vue-cli-service test:unit`                                                                                                 |
| `test:unit:debug`  | `node --inspect-brk ./node_modules/jest/bin/jest.js --no-cache --runInBand`                                                 |
| `i18n:report`      | `vue-cli-service i18n:report --src './src/**/*.?(js|vue)' --locales './src/locales/**/*.json',`                             |
| `generate:css`     | `tailwind build src/assets/css/tailwind.css -o public/styles.css`                                                           |
| `start`            | `node ./mock_server/index.js`                                                                                               |
| `theo`             | `theo ./src/tokens/_tokens.yml --transform web --format module.js,common.js,custom-properties.css,scss --dest ./src/styles` |
| `theo:onchange`    | `onchange \"./resources/tokens/*.yml\" -- npm run theo`                                                                     |
