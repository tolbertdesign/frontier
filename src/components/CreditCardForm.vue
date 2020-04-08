<template>
  <div class="cc-form">
    <div class="form-group">
      <label class="sr-only">{{ lang.card_number }}</label>
      <div
        id="card-number"
        :class="{ 'is-invalid': isInvalid('number') }"
        class="hosted-field form-control is-standard"
      />
    </div>
    <div class="form-row">
      <div class="form-group col-7">
        <label class="sr-only">{{ lang.expiration_date }}</label>
        <div
          id="expiration-date"
          :class="{ 'is-invalid': isInvalid('expirationDate') }"
          class="hosted-field form-control is-standard"
        />
      </div>
      <div class="form-group col">
        <label class="sr-only">{{ lang.cvv }}</label>
        <div
          id="cvv"
          :class="{ 'is-invalid': isInvalid('cvv') }"
          class="hosted-field form-control is-standard"
        />
      </div>
    </div>
    <div
      v-if="error.message !== null"
      class="alert has-error"
    >
      {{ error.message }}
    </div>
  </div>
</template>

<script>
export default {
  props: {
    error: {
      type: Object,
      default: function () {
        return {
          code: '',
          message: '',
          details: {},
        }
      },
    },
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
  },
  methods: {
    isInvalid (field) {
      return this.error.code === 'HOSTED_FIELDS_FIELDS_EMPTY' || this.error.details.invalidFieldKeys.indexOf(field) > -1
    },
  },
}
</script>
