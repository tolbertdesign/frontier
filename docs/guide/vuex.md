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

## Example `store.js`

```js
export default new Vuex.Store({
  state: {
    users: [],
    selectedUserId: null,
    isFetching: false,
  },
  mutations: {
    setUsers(state, { users }) {
      state.users = users
    },
    setSelectedUser(state, id) {
      state.selectedUserId = id
    },
    setIsFetching(state, bool) {
      state.isFetching = bool
    },
  },
  getters: {
    selectedUser: state => state.users.find(user => user.login.uuid === state.selectedUserId),
  },
  actions: {
    fetchUsers({ commit }) {
      commit('setIsFetching', true)
      return axios
        .get('https://randomuser.me/api/?nat=gb,us,au&results=5&seed=abc')
        .then(res => {
          setTimeout(() => {
            commit('setIsFetching', false)
            commit('setUsers', { users: res.data.results })
          }, 2500)
        })
        .catch(error => {
          commit('setIsFetching', false)
          console.error(error)
        })
    },
  },
})
```

---

title: "@/vuex/store.js"
---

## `actions`

### `setContentGroup`

```js
setContentGroup: ({ state, commit }, route) => {
  if (state.contentGroup !== route.name) {
    gtag('config', 'UA-18391724-4', {
      'page_title': route.name,
      'page_path': route.path,
      'content_group1': route.name
    });
    commit('SET_CONTENT_GROUP', route.name)
  }
}
```

## `state` (rootState)

## `getters`
