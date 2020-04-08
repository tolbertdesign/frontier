<template>
  <div>
    <h1 class="text-60">
      {{ lang.create_your_account }}
    </h1>
    <p class="text-13">
      {{ lang.get_started }}
    </p>
    <p>
      <button
        dusk="parent-registration"
        class="btn btn-primary btn-round py-2 d-block mw-200px w-200px mx-auto mb-4 btn-drop-shadow text-15"
        @click="_setUserType('parent')"
      >{{ buttonText }}</button>
      <button
        dusk="teacher-registration"
        class="btn btn-success btn-round py-2 d-block mw-200px w-200px mx-auto text-15 mb-4"
        @click="_setUserType('teacher')"
      >{{ lang.im_a_teacher }}</button>
      <a
        data-toggle="modal"
        data-target="#sponsorInstructionModal"
        href="#"
        class="pledge-a-student btn btn-white-outline btn-813-dk-grey-outline btn-round py-2 d-block mw-200px mx-auto text-15"
        @click="_sponsor"
      >{{ lang.im_a_sponsor }}</a>
    </p>
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
