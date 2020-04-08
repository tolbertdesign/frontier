<template>
  <div v-if="false" />
</template>

<script>
export default {
  name: 'StoreLoader',
  props: {
    user: {
      type: Object,
      default: null,
    },
    betaBannerKillSwitch: {
      type: Boolean,
      default: null,
    },
    s3Bucket: {
      type: String,
      default: '',
    },
    avatarPath: {
      type: String,
      default: '',
    },
    minPasswordLength: {
      type: String,
      default: '',
    },
    lang: {
      type: Object,
      default: null,
    },
    pledgeTypes: {
      type: Array,
      default: null,
    },
    sponsorTypes: {
      type: Array,
      default: null,
    },
    states: {
      type: Array,
      default: null,
    },
    countries: {
      type: Array,
      default: null,
    },
  },
  created () {
    this.$store.dispatch('setUser', this.user)
    this.$store.commit('SET_S3_BUCKET', this.s3Bucket)
    this.$store.commit('SET_BETA_BANNER_KILL_SWITCH', this.betaBannerKillSwitch)
    this.$store.commit('SET_AVATAR_PATH', this.avatarPath)
    this.$store.commit('SET_LANG', this.lang)
    this.$store.commit('PLEDGE_TYPES', this.pledgeTypes)
    this.$store.commit('SPONSOR_TYPES', this.sponsorTypes)
    this.$store.commit('COUNTRIES', this.countries)
    this.$store.commit('STATES', this.states)
    this.$store.commit('SET_MIN_PASSWORD_LENGTH', parseInt(this.minPasswordLength))
  },
}
</script>
