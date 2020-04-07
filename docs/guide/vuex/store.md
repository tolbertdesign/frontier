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
