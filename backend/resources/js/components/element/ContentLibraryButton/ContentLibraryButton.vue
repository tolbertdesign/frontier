<template>
  <a
    :href="url"
    target="_blank"
    class="bg-secondary px-4 py-2 rounded-full text-white hover:text-white"
  >
    <FontAwesomeIcon
      :icon="['far', 'external-link-square']"
    />
    <span class="pl-1">{{ lang.content_library_button }}</span>
  </a>
</template>

<script>
export default {
  name: 'ContentLibraryButton',
  status: 'prototype',
  release: '1.0.0',
  data () {
    return {
      url: 'https://boosterthoncharacter.com/',
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
  },
}
</script>
