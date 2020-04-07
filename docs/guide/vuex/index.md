---
title: Vue
lang: en-US
---

In effort to optimize our Vue data design. we need to investigate a theory that was derived in our last meeting on how to approach this problem. What we’re going to attempt to do is refactor one (most simple) object to have a corresponding module that manages the data in both the state and the “God” object to prevent breaking any other areas of the code that would be referencing the “God” object.

1. Select an Object to refactor/create a module for
2. Create a module to handle the getting, setting and mutations of the data in both the State and the “God” object
3. Very nothing else was unintentionally broken from adding the new module
4. Have a meeting to review the implementation as a team

<!-- textlint-disable terminology -->

::: vue
.
├── docs
│   ├── .vuepress _(**Optional**)_
│   │   ├── `components` _(**Optional**)_
│   │   ├── `theme` _(**Optional**)_
│   │   │   └── Layout.vue
│   │   ├── `public` _(**Optional**)_
│   │   ├── `styles` _(**Optional**)_
│   │   │   ├── index.styl
│   │   │   └── palette.styl
│   │   ├── `templates` _(**Optional, Danger Zone**)_
│   │   │   ├── dev.html
│   │   │   └── ssr.html
│   │   ├── `config.js` _(**Optional**)_
│   │   └── `enhanceApp.js` _(**Optional**)_
│   │
│   ├── README.md
│   ├── guide
│   │   └── README.md
│   └── config.md
│
└── package.json
:::

<!-- textlint-enable -->

## Vuex Modules

## Actions

```js
export const actions = {
  save: () => {
  }
}
```

<!-- ![](https://cominex.net/assets/video/vuex_modules.mp4)' -->

#### Lang

The `Lang` module

```js
import Lang from '@/vuex/modules/lang'
```

#### User

The `User` module

```js
import User from '@/vuex/modules/user'
```

#### Participant

The `Participant` module

```js
import Participant from '@/vuex/modules/participant'
```

#### Program

The `Program` module

```js
import Program from '@/vuex/modules/program'
```

#### Pledge

The `Pledge` module

```js
import pledge from '@/vuex/modules/pledge'
```

#### Notification

The `Notification` module

```js
import Notification from '@/vuex/modules/notification'
```

#### Classroom

The `Classroom` module

```js
import Classroom from '@/vuex/modules/classroom'
```
