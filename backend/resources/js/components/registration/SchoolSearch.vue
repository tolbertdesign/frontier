<template>
  <div>
    <h2 class="mt-4 text-30 mb-4">
      {{ lang.school_search_header }}
    </h2>
    <div class="form-group  mx-auto">
      <label class="sr-only">{{ lang.last_name }}</label>
      <input
        :placeholder="lang.placeholder_school_search"
        type="text"
        class="form-control text-16"
        name="school_search"
        required
        @input="search"
      >
      <ul
        v-show="schools.length"
        class="list-group"
      >
        <li
          v-for="(school, index) in schools"
          :key="index"
          :class="{'active': regCode === school.registration_code}"
          class="radio text-left text-gray text-16 list-group-item list-group-item-action"
          @click="selectSchool(school)"
        >
          <div class="font-weight-bold">
            {{ school.name }}
          </div>
          <div>{{ school.event_name }}</div>
          <div>{{ school.city }}, {{ school.state }}</div>
        </li>
      </ul>
    </div>

    <p class="text-12 fw-300"><a
      class="text-inherit fw-600"
      href="#"
      data-target="#schoolSearchHelpModal"
      data-toggle="modal"
    >{{ lang.school_search.click_here }}</a> {{ lang.school_search.search_school_help }}</p>
    <p class="text-12 gap-strike my-4 mw-200px mx-auto">
      <span class="strike" />
      <span>or</span>
      <span class="strike" />
    </p>
    <p class="text-12 fw-300">
      <a
        class="text-inherit fw-600"
        href="#"
        @click="hideRegCode = !hideRegCode"
      >{{ lang.school_search.click_here }}</a>
      {{ lang.school_search.enter_registration_code }}

    </p>

    <div
      :class="{invisible:hideRegCode}"
      class="form-group mx-auto"
    >
      <p
        v-if="registrationCodeResponse !== null"
        class="text-invalid text-11 alert alert-danger"
      >{{ registrationCodeResponse }}</p>
      <label class="sr-only">{{ lang.registration_code }}</label>
      <input
        v-model="regCode"
        :placeholder="lang.placeholder_reg_code"
        type="text"
        class="form-control text-16 mb-5"
        name="reg_code"
        required
      >

      <button
        class="btn btn-primary btn-round d-block w-200px mx-auto mb-3 btn-drop-shadow text-18"
        @click="next"
      >Next</button>
    </div>
    <a
      v-if="userHasParticipants"
      href="#"
      class="btn btn-danger btn-round d-block w-200px mx-auto btn-drop-shadow text-15 mb-15"
      @click="cancel"
    >{{ lang.cancel }}</a>
  </div>
</template>

<script>

export default {
  props: {
    errors: {
      type: Array,
      default: null,
    },
    cancel_link: {
      type: String,
      default: '',
    },
  },
  data () {
    return {
      hideRegCode: true,
      regCode: '',
      schools: [],
      registrationCodeResponse: null,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    userHasParticipants () {
      return this.$store.getters.hasParticipants
    },
  },
  mounted: function () {
    this.hjTrigger('dash-school-search')
  },
  methods: {
    search (event) {
      const searchTerm = event.target.value
      if (searchTerm.length >= 3) {
        axios.get('/v3/api/schools/' + searchTerm)
          .then(response => {
            this.schools = response.data
          }).catch(error => {
            // TODO: LOGGLY
            console.error(error)
          })
      } else {
        this.schools = []
      }
    },
    selectSchool (school) {
      this.regCode = school.registration_code
      this.next()
    },
    next () {
      if (this.regCode) {
        axios.get('/v3/api/schools/registration-code/' + this.regCode)
          .then(response => {
            // validate the response was successful
            if (response.data.error === undefined) {
              // send the response over to the next panel
              this.$store.commit('NEW_PARTICIPANT', response.data)
              this.$emit('participant-registration', response.data)
            } else {
              this.registrationCodeResponse = response.data.error
            }
          }).catch(error => {
            // TODO: LOGGLY
            console.error(error)
          })
      }
    },
    cancel () {
      window.location.href = this.cancel_link
    },
  },
}
</script>
