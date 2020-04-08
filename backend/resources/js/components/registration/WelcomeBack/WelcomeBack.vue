<template>
  <div>
    <h1 class="text-48 mw-200px mx-auto">
      {{ lang.welcome_back }}
    </h1>
    <p class="mt-12">
      <a
        v-if="isBetaUser && !isOrgAdmin"
        href="/v3/home/dashboard"
        class="btn btn-white-outline btn-813-dk-grey-outline btn-round mb-4 py-2 d-block mw-200px mx-auto text-15 w-200px"
      >{{ lang.back_to_dashboard }}</a>
      <a
        v-if="isOrgAdmin"
        :href="`/v3/tkdashboard/?redirect=admin`"
        class="btn btn-white-outline btn-813-dk-grey-outline btn-round mb-4 py-2 d-block mw-200px mx-auto text-15 w-200px"
      >{{ lang.admin_dashboard }}</a>
      <button
        class="btn btn-primary btn-round py-2 d-block mw-200px mx-auto mb-4 btn-drop-shadow text-15 w-200px"
        @click="_setUserType('parent')"
      >{{ buttonText }}</button>
      <button
        class="btn btn-success btn-round py-2 d-block mw-200px mx-auto mb-4 text-15 w-200px"
        @click="_setUserType('teacher')"
      >{{ lang.im_a_teacher }}</button>
      <a
        data-toggle="modal"
        data-target="#sponsorInstructionModal"
        href="#"
        class="btn btn-white-outline btn-813-dk-grey-outline btn-round py-2 d-block mw-200px mx-auto text-15 w-200px"
        @click="_sponsor"
      >{{ lang.im_a_sponsor }}</a>

      <a
        id="regButtonsExplanationModalAnchor"
        data-toggle="modal"
        data-target="#regButtonsExplanationModal"
        href="#"
        class="py-3 d-block mw-200px mx-auto text-15 text-white font-weight-bold"
        @click="_whatDoesThisMean"
      >{{ lang.what_does_this_mean }}</a>

    </p>
  </div>
</template>

<script>
export default {
  props: {
    isBetaUser: {
      type: Boolean,
      default: false,
    },
    isOrgAdmin: {
      type: Boolean,
      default: false,
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
    this.hjTrigger('dash-welcome-back')
  },
  methods: {
    _setUserType (val) {
      this.gaEvent('Titan Registration', 'Welcome Back', val)
      axios.get('/v3/api/validate-profile-complete')
        .then((response) => {
          if (response.data.valid === true) {
            this.$store.commit('SET_USER_TYPE', val)
            this.$emit('selection-made')
          } else {
            this.$store.commit('SET_USER_TYPE', 'incompleteProfile')
            this.$emit('incomplete-registration')
          }
        })
    },
    _sponsor () {
      this.gaEvent('Titan Registration', 'Welcome Back', 'sponsor')
    },
    _whatDoesThisMean () {
      this.gaEvent('Titan Registration', 'Welcome Back', 'What does this mean')
    },
  },
}

</script>
