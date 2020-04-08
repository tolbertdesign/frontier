<template>
  <div class="select-input form-group mx-auto position-relative">
    <select
      v-model="selection"
      :class="[error != undefined ? 'is-invalid' : '']"
      :required="required"
      :name="name"
    >
      <option
        v-if="default_text !== null"
        :value="default_value"
        disabled
      >{{ default_text }}</option>
      <option
        v-for="(value, key) in options"
        :key="key"
        :value="value"
      >{{ value }}</option>
      <slot />
    </select>
    <i class="fal fa-angle-down" />
    <div
      v-if="error != undefined"
      class="error-msg"
    >
      {{ error[0] }}
    </div>
  </div>
</template>

<script>

export default {
  props: {
    default_value: {
      type: String,
      default: null,
    },
    default_text: {
      type: String,
      default: null,
    },
    options: {
      type: Object,
      default: null,
    },
    error: {
      type: Object,
      default: null,
    },
    name: {
      type: String,
      default: '',
    },
    required: {
      type: Boolean,
      default: false,
    },
    value: {
      type: [String, Number],
      default: '',
    },
  },
  data () {
    return {
      selection: this.value,
    }
  },
  watch: {
    selection (val) {
      this.$emit('input', val)
    },
  },
}
</script>
