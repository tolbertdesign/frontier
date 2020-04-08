<template>
  <div class="form-group mx-auto">
    <label class="sr-only">{{ label }}</label>
    <input
      v-model="textValue"
      :type="type"
      :class="[error != undefined ? 'is-invalid' : '', 'form-control text-16']"
      :name="name"
      :placeholder="label"
      required
    >
    <i
      v-if="tip !== ''"
      :title="tip"
      class="fas fa-info-circle tip"
      data-toggle="tooltip"
      data-placement="top"
    />
    <div
      v-if="error != undefined"
      class="error-msg"
    >
      {{ error[0] }}
    </div>
  </div>
</template>

<script>
// uses a 16px font this prevents iphone zoom
export default {
  props: {
    type: {
      type: String,
      default: 'text',
    },
    name: {
      type: String,
      default: '',
    },
    label: {
      type: String,
      default: '',
    },
    error: {
      type: Object,
      default: null,
    },
    tip: {
      type: String,
      default: '',
    },
    value: {
      type: String,
      default: '',
    },
  },
  data () {
    return {
      textValue: this.value,
    }
  },
  watch: {
    textValue (val) {
      this.$emit('input', val)
    },
  },
}
</script>
