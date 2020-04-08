<template>
  <div class="school-search montserrat">
    <h2 class="text-30 mb-4">
      {{ lang.school_search_header }}
    </h2>
    <div class="form-group mx-auto">
      <input
        :placeholder="lang.placeholder_school_search"
        type="text"
        class="form-control text-16 mx-auto"
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
          class="radio text-left text-16 list-group-item list-group-item-action"
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

    <p class="text-12">
      {{ lang.search_help_1 }}
      <a
        class="text-primary font-weight-bold"
        href="#"
        data-target="#schoolSearchHelpModal"
        data-toggle="modal"
      >
        {{ lang.search_help_2 }}
      </a>
      {{ lang.search_help_3 }}
    </p>
  </div>
</template>

<script>
export default {
  name: 'SchoolSearch',
  status: 'prototype',
  release: '1.0.0',
  props: {
    errors: {
      type: Array,
      default: null,
    },
    searchUrl: {
      type: String,
      default: '',
    },
    schoolUrl: {
      type: String,
      default: '',
    },
    lang: {
      type: Object,
      default: null,
    },
  },
  data () {
    return {
      hideRegCode: true,
      regCode: '',
      schools: [],
    }
  },
  computed: {},
  methods: {
    search (event) {
      const searchTerm = event.target.value
      if (searchTerm.length >= 3) {
        axios
          .get(this.search_url + '/' + searchTerm)
          .then(response => {
            this.schools = response.data
          })
          .catch(error => {
            // TODO: LOGGLY
            console.error(error)
          })
      } else {
        this.schools = []
      }
    },
    selectSchool (school) {
      window.location.href = this.school_url + '/' + school.id
    },
  },
}
</script>
