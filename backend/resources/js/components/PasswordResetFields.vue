<template>
  <div class="mw-250px mx-auto">
    <div class="form-group text-left">
      <label
        for="email"
      >{{ email_address_label }}</label>
      <input
        :class="[email_errors.length > 0 ? 'is-invalid' : '','form-control mw-250px mx-auto']"
        :placeholder="email_address_label"
        type="email"
        name="email"
        required
      >
      <div
        v-for="(error, index) in email_errors"
        :key="index"
        class="text-right error-msg"
        v-html="error"
      />
    </div>
    <label class="text-center mb-2 mt-2">{{ password_requirements_label }}</label>
    <div class="form-group text-left mb-2">
      <label
        for="email"
      >{{ password_label }}</label>
      <input
        :class="[ password_errors.length > 0 ? 'is-invalid': '','form-control mw-250px mx-auto']"
        :placeholder="password_label"
        type="password"
        name="password"
        required
      >
      <div
        v-for="(error, index) in password_errors"
        :key="index"
        class="text-right error-msg pt-1"
        v-html="error"
      />
      <div class="form-group text-left mt-2">
        <label
          for="email-confirm"
        >{{ password_confirm_label }}</label>
        <input
          :class="[ error ? 'is-invalid': '','form-control mw-250px mx-auto']"
          :placeholder="password_confirm_label"
          type="password"
          name="password_confirmation"
          required
        >
      </div>
    </div>
  </div></template>

<script>
export default {
  props: {
    email_address_label: {
      type: String,
      default: '',
    },
    password_label: {
      type: String,
      default: '',
    },
    password_confirm_label: {
      type: String,
      default: '',
    },
    error: {
      type: String,
      default: '',
    },
    password_requirements_label: {
      type: String,
      default: '',
    },
    email_errors: {
      type: Array,
      default: null,
    },
    password_errors: {
      type: Array,
      default: null,
    },
  },
}
</script>
