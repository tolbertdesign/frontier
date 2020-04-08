<template>
  <div>
    <h1 class="text-30 fw-500 lh-42 d-block mt-8 mb-4">
      {{ lang.participant_registration.awesome_exclaim }}
      <br>
      {{ lang.participant_registration.thanks_for_student }}
    </h1>
    <h3 class="text-18 fw-200 lh-22 d-block mb-3">
      {{ lang.participant_registration.need_another }}
    </h3>
    <button
      class="btn btn-primary btn-round d-4lock w-200px mx-auto mb-3 btn-drop-shadow text-18"
      @click="_registerAnotherStudent"
    >{{ lang.yes }}</button>
    <a
      href="/v3/home/dashboard"
      class="no-button btn btn-navy btn-round d-block w-200px mx-auto mb-3 btn-drop-shadow text-18 d-block"
      @click="_registerComplete"
    >{{ lang.no }}</a>
  </div>
</template>

<script>

export default {
  computed: {
    lang () {
      return this.$store.state.lang
    },
  },
  mounted: function () {
    this.hjTrigger('dash-participant-register-success')
    const confetti = this.$confetti
    confetti.start({
      shape: 'rect',
    })

    setTimeout(function () {
      confetti.stop()
    }, 3000)
  },
  methods: {
    _registerComplete () {
      this.gaEvent('Titan Registration', 'Parent Registration', 'Completed')
    },
    _registerAnotherStudent (event) {
      this.gaEvent('Titan Registration', 'Parent Registration', 'Additional Participant')
      this.$emit('school-search', event.target.value)
    },
  },
}
</script>
