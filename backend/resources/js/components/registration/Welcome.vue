<template>
  <div>
    <h1 class="text-60">
      {{ lang.welcome }}
    </h1>
    <p class="text-18 pb-3 mw-250px mx-auto font-weight-light">
      {{ lang.landing_tagline }}
    </p>
    <p>
      <button
        class="btn btn-grey btn-round py-2 d-block mw-200px w-200px mx-auto mb-4 btn-drop-shadow text-15"
        type="button"
        @click="$emit('sign-up')"
      >{{ lang.sign_up }}</button>
    </p>
    <p class="text-12 gap-strike my-4 mw-200px mx-auto">
      <span class="strike" /><span>{{ lang.or }}</span><span class="strike" />
    </p>
    <p class="text-13"><a
      :href="login_url"
      class="btn btn-primary mt-2 py-2 btn-round d-block mw-200px mx-auto btn-drop-shadow text-15"
      @click="_login"
    >{{ lang.login }}</a></p>
  </div>
</template>

<script>
export default {
  props: {
    login_url: {
      type: String,
      default: null,
    },
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    buttonText () {
      if (window.location.hostname.includes('funrunpro')) {
        return this.lang.im_a_participant
      }

      return this.lang.im_a_parent
    },
  },
  mounted: function () {
    this.hjTrigger('dash-welcome')
  },
  methods: {
    _setUserType (type) {
      this.gaEvent('Titan Registration', 'Landing Page', type)
      this.$store.commit('SET_USER_TYPE', type)
      this.$emit('register')
    },
    _login () {
      this.gaEvent('Titan Registration', 'Landing Page', 'login')
    },
    _sponsor () {
      this.gaEvent('Titan Registration', 'Landing Page', 'sponsor')
    },
  },
}
</script>
