<template>
  <div v-if="false" />
</template>
<script>
export default {
  name: 'Loader',
  props: {
    user: {
      type: Object,
      default: null,
    },
    beta_banner_kill_switch: {
      type: Boolean,
      default: null,
    },
    s3_bucket: {
      type: String,
      default: '',
    },
    avatar_path: {
      type: String,
      default: '',
    },
    min_password_length: {
      type: String,
      default: '',
    },
    lang: {
      type: Object,
      default: null,
    },
    pledge_types: {
      type: Array,
      default: null,
    },
    sponsor_types: {
      type: Array,
      default: null,
    },
    countries: {
      type: Array,
      default: null,
    },
    states: {
      type: Array,
      default: null,
    },
  },
  created () {
    this.$store.dispatch('setUser', this.user)
    this.$store.commit('SET_S3_BUCKET', this.s3_bucket)
    this.$store.commit('SET_BETA_BANNER_KILL_SWITCH', this.beta_banner_kill_switch)
    this.$store.commit('SET_AVATAR_PATH', this.avatar_path)
    this.$store.commit('SET_LANG', this.lang)
    this.$store.commit('PLEDGE_TYPES', this.pledge_types)
    this.$store.commit('SPONSOR_TYPES', this.sponsor_types)
    this.$store.commit('COUNTRIES', this.countries)
    this.$store.commit('STATES', this.states)
    this.$store.commit('SET_MIN_PASSWORD_LENGTH', parseInt(this.min_password_length))
  },

}
</script>
