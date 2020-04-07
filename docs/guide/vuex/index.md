---
title: Vuex
lang: en-US
---

## Directory Structure

<!-- textlint-disable terminology -->
```
├── vuex
│   ├── modules
│   │   ├── classroom
│   │   ├── emailer
│   │   ├── message
│   │   ├── microsite
│   │   ├── notification
│   │   ├── participant
│   │   ├── payment
│   │   ├── pledge
│   │   ├── program
│   │   ├── sponsor
│   │   └── user
│   └── store.js
```
<!-- textlint-enable -->

## Vuex Modules

## `@/vuex/store`

## `state`

```js
export const state = {
  lang: Object,
  s3Bucket: '',
  minPasswordLength: 0,
  contentGroup: '',
  activeTab: 0,
  states: [],
  countries: [],
  forcePageRouteRefresh: false,
}
```

## `getters`

### `actions`

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

```js
export const actions = {
  save: () => {
  }
}
```

![](https://cominex.net/assets/video/vuex_modules.mp4)'
