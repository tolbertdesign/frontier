<template>
  <div>
    <h1 class="mt-8 mb-15 text-50 fw-500">
      {{ lang.welcome }}
    </h1>
    <div class="registration-form-constraint d-block mx-auto">
      <h2 class="mb-4 mt-12 text-30 fw-200">
        {{ lang.sign_up }}
      </h2>
      <google-login @link-clicked="_registerGAEvent" />
      <a
        id="email_registration"
        class="btn btn-primary btn-round d-block w-200px mx-auto btn-drop-shadow text-18 d-flex align-items-center justify-content-center align text-white"
        @click="$emit('email-registration', $event.target.value)"
      ><i class="far fa-envelope mr-10 text-21" /> Use My Email</a>
      <p
        class="mt-12 text-14 fw-200"
      >{{ lang.sign_in_message }} <a
        :href="login_url"
        class="parent_login"
      >{{ lang.sign_in }}</a></p>
    </div>
  </div>
</template>

<script>

export default {
  props: {
    login_url: {
      type: String,
      default: '',
    },
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
  },
  mounted: function () {
    this.hjTrigger('dash-registration-type')
  },
  methods: {
    _registerGAEvent () {
      if (this.$store.getters.getUserType === 'parent') {
        this.gaEvent('Titan Registration', 'Parent Registration', 'Google Registration')
      } else {
        this.gaEvent('Titan Registration', 'Teacher Registration', 'Google Registration')
      }
    },
  },
}
</script>
