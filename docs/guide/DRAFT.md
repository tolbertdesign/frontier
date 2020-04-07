---
title: Idea and content drafts
---

Stuff to organize

## Dependencies

``` js{4}
export default {
  data () {
    return {
      msg: 'Highlighted!'
    }
  }
}
```

- Buefy
- Laravel
- Nuxt
- Storybook
- Tailwind CSS
- Vue
- Vuepress

## Base URL

```
![An image](./image.png)
<img :src="$withBase('/foo.png')" alt="foo">
```

| Name     | Description                                                                       | Type    | Values | Default |
| -------- | --------------------------------------------------------------------------------- | ------- | ------ | ------- |
| `active` | Whether modal is active or not, use the .sync modifier to make it two-way binding | Boolean | —      | `false` |

## Docuentation

- Getting Started
- Project Structure
- Coding style for commits
- Vuex Store (State Management)
- Mixins
- Filters
- Directives
- Middleware
- Axon
- Vue Router
- Base Components
- Layout
- Modals
- Forms
- Buttons
  - EditButton
  - SaveButton
  - CancelButton
  - UploadButton
- Toggles
  - RewardsToggle
  - NavbarToggle
- Demo App [J](https://app.tolbert.design)
- Demo Backend [A](https://tolbert.design/v0/api)
  - Laravel v7.x
  - Tailwind v1.2
  - Buefy
- Bundle Improvements

```
    "docs:dev": "vuepress dev docs",

  <<< @/filepath
  <<< @/filepath{highlightLines}
  <<< @/../@vuepress/markdown/__tests__/fragments/snippet.js{2}
```

If your module `export default` a Vue component, you can register it dynamically

```
<template>
  <component v-if="dynamicComponent" :is="dynamicComponent"></component>
</template>

<script>
export default {
  data() {
    return {
      dynamicComponent: null
    }
  },

  mounted () {
    import('./lib-that-access-window-on-import').then(module => {
      this.dynamicComponent = module.default
    })
  }
}
</script>
```
