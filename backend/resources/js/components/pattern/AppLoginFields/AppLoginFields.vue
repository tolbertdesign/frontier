<template>
  <div>
    <div class="form-group">
      <label
        for="email"
        class="sr-only"
      >
        {{ email_address_label }}
      </label>
      <input
        :class="[error ? 'is-invalid' : '','form-control mw-250px mx-auto']"
        :placeholder="email_address_label"
        type="email"
        name="email"
        required
      >
    </div>
    <div class="form-group">
      <label
        for="email"
        class="sr-only"
      >
        {{ password_label }}
      </label>
      <input
        :type="passwordType ? 'password': 'text'"
        :class="[ error ? 'is-invalid': '','form-control mw-250px mx-auto']"
        :placeholder="password_label"
        name="password"
        required
      >
    </div>
    <div class="d-flex mw-250px mx-auto mb-4">
      <div class="checkbox text-left mx-auto">
        <label>
          <input
            type="checkbox"
            name="remember"
          > {{ remember_me_label }}
        </label>
      </div>
      <div class="show-password text-right mx-auto">
        <a
          href="javascript:void(0);"
          @click="passwordType = !passwordType"
        >
          {{ show_password_label }}
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AppLoginFields',
  status: 'prototype',
  release: '1.0.0',
  props: {
    emailAddressLabel: {
      type: String,
      default: '',
    },
    passwordLabel: {
      type: String,
      default: '',
    },
    rememberMeLabel: {
      type: String,
      default: '',
    },
    showPasswordLabel: {
      type: String,
      default: '',
    },
    error: {
      type: String,
      default: '',
    },
  },
  data: function () {
    return {
      passwordType: true,
    }
  },
}
</script>
