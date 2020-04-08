<template>
  <div>
    <h1 class="welcome teachers mt-8 mb-15 text-29 fw-500">
      Enter Teacher Code
    </h1>
    <div class="registration-form-constraint d-block mx-auto">
      <p class="text-14 lh-22 fw-200">
        Haven't received your Teacher Code yet? Ask your Booster representative!
      </p>
      <p class="text-invalid text-11">
        {{ teacher_code_response }}
      </p>
      <input
        v-model="$parent.teacher_registration_code"
        name="teacher_registration_code"
        class="form-control mb-28px"
        type="text"
        placeholder="Enter Code"
      >
      <input
        id="agree"
        v-model="$parent.agrees_terms"
        name="agree"
        class="checkbox"
        type="checkbox"
        value="agree"
      >
      <label
        class="text-12 mb-28px"
        for="agree"
      >
        {{ lang.participant_registration.participation_terms_prefix }}
        <a
          id="print-terms"
          href="/v3/terms"
          target="_blank"
        >{{ lang.participant_registration.participation_terms_link }}</a>
      </label>
      <button
        :disabled="!$parent.agrees_terms || submitting"
        class="btn btn-primary btn-round d-block w-200px mx-auto mb-3 btn-drop-shadow text-18"
        type="submit"
        @click="validate_teacher_code()"
      >Next
        <i
          v-if="submitting"
          class="fa fa-spinner fa-spin"
        />
      </button>
      <a
        href="#"
        class="btn btn-navy btn-round d-block w-200px mx-auto mb-3 btn-drop-shadow text-18 d-block"
        @click="cancel"
      >{{ lang.cancel }}</a>
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
    cancel_link: {
      type: String,
      default: '',
    },
  },
  data: function () {
    return {
      teacher_code_response: null,
      submitting: false,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
  },
  mounted: function () {
    this.hjTrigger('dash-welcome-teacher')
  },
  methods: {
    validate_teacher_code: function () {
      this.submitting = true
      axios.get('/v3/api/registration/validate_teacher_code/' + this.$parent.teacher_registration_code)
        .then((response) => {
          this.submitting = false
          if (response) {
            if (response.data.success) {
              $('input[name="teacher_registration_code"]').removeClass('is-invalid')
              this.gaEvent('Titan Registration', 'Teacher Registration', 'Completed')
              this.$emit('teacher_registered')
            } else {
              this.teacher_code_response = response.data.message
              $('input[name="teacher_registration_code"]').addClass('is-invalid')
            }
          }
        })
    },
    cancel () {
      window.location.href = this.cancel_link
    },
  },
}
</script>
