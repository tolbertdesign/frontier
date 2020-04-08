<template>
  <label>
    {{ label }}
    <input
      v-bind="$attrs"
      :value="value"
      class="w-full border p-4"
      v-on="listeners"
    >
  </label>
</template>

<docs>
# BaseInput Component

This is a generic button element
</docs>

<script>
export default {
  name: 'BaseInput',
  inheritAttrs: false,
  props: {
    label: {
      type: String,
    },
    value: {
      type: String,
    },
  },
  computed: {
    listeners () {
      return {
        ...this.$listeners,
        input: event => this.$emit('input', event.target.value),
      }
    },
  },
}
</script>
