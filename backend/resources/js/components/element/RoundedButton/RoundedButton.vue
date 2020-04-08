<template>
  <a
    :href="link"
    class="max-w-xs text-24 button shadow is-medium is-rounded is-fullwidth font-semibold mx-auto"
  >
    {{ text }}
  </a>
</template>

<script>
export default {
  name: 'RoundedButton',
  status: 'prototype',
  release: '1.0.0',
  props: {
    text: {
      type: String,
      default: '',
    },
    link: {
      type: String,
      default: '',
    },

  },
}
</script>
