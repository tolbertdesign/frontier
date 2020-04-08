<template>
  <a
    id="facebook"
    class="btn btn-social-login btn-round py-2 d-block mw-200px mx-auto mb-4 btn-drop-shadow"
    href=""
  >
    <img
      :alt="lang.facebook_logo"
      class="login-logo pl-2"
      src="/img/facebook-logo.png"
    >{{ lang.facebook_account }}
  </a>
</template>

<script>

export default {
  props: {
    set_lang: {
      type: Object,
      default: undefined,
    },
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
  },
  mounted () {
    if (this.set_lang !== undefined) { this.$store.commit('SET_LANG', this.set_lang) }
  },
}
</script>
