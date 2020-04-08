<template>
  <div
    :class="{ hasError: v && v.$error }"
    class="field mb-4"
  >
    <label
      v-if="label"
      for="textInput"
      class="inline-block mb-1 pl-2 text-gray-700 text-sm"
    >
      {{ label }}
      <span v-if="required">*</span>
    </label>
    <div class="control">
      <TheMask
        v-if="mask"
        v-model.number="model"
        :mask="mask"
        :type="type"
        :placeholder="placeholder"
        :class="{
          'is-danger border-red-600': v && v.$error && v.$dirty,
          'text-right': type === 'number'
        }"
        name="textInput"
        class="input form-input w-full mb-1 border border-gray-400 rounded-lg focus:shadow-outline focus:bg-blue-100"
      />
      <input
        v-else
        v-model="model"
        :type="type"
        :placeholder="placeholder"
        :class="{
          'is-danger border-red-600': v && v.$error && v.$dirty,
          'text-right': type === 'number'
        }"
        name="textInput"
        class="input form-input w-full mb-1 border border-gray-400 rounded-lg focus:shadow-outline focus:bg-blue-100"
      >
    </div>
    <p
      v-if="required && v && !v.required && v.$dirty"
      class="help is-danger pl-2 text-xs text-red-500"
    >
      {{ label }} {{ lang.is_required }}
    </p>
    <p
      v-if="type == 'email' && v && !v.email && v.$dirty"
      class="help is-danger pl-2 text-xs text-red-500"
    >
      {{ label }} {{ lang.is_invalid }}
    </p>
    <p
      v-if="type == 'tel' && v && !v.isPhone && v.$dirty"
      class="help is-danger pl-2 text-xs text-red-500"
    >
      {{ label }} {{ lang.is_invalid }}
    </p>
    <p
      v-if="type == 'email' && v && !v.notBooster && v.$dirty"
      class="help is-danger pl-2 text-xs text-red-500"
    >
      {{ label }} {{ lang.not_booster }}
    </p>
    <p
      v-if="type == 'password' && v && !v.sameAsPassword && v.$dirty"
      class="help is-danger pl-2 text-xs text-red-500"
    >
      {{ label }} {{ lang.must_be_identical }}
    </p>
    <p
      v-if="type == 'password' && v && v.minLength && v.$dirty"
      class="help is-danger pl-2 text-xs text-red-500"
    >
      {{ lang.at_least }} {{ v.$params.minLength.min }} {{ lang.characters }}
    </p>

    <p
      v-if="type == 'password' && v && v.hasNumber && v.$dirty"
      class="help is-danger pl-2 text-xs text-red-500"
    >
      {{ lang.at_least }} {{ lang.number }}
    </p>
    <p
      v-if="type == 'password' && v && v.hasLowercase && v.$dirty"
      class="help is-danger pl-2 text-xs text-red-500"
    >
      {{ lang.at_least }} {{ lang.lowercase }}
    </p>
    <p
      v-if="type == 'password' && v && v.hasUppercase && v.$dirty"
      class="help is-danger pl-2 text-xs text-red-500"
    >
      {{ lang.at_least }} {{ lang.uppercase }}
    </p>
    <p
      v-if="type == 'password' && v && v.hasSpecialCharacter && v.$dirty"
      class="help is-danger pl-2 text-xs text-red-500"
    >
      {{ lang.at_least }} {{ lang.symbol }}
    </p>
    <p
      v-if="helpText"
      class="help pl-2 text-xs"
    >
      {{ helpText }}
    </p>
  </div>
</template>

<script>
import { TheMask } from 'vue-the-mask'

export default {
  name: 'BaseInput',
  components: { TheMask },
  props: {
    type: {
      type: String,
      default: 'text',
    },
    value: {
      type: [String, Number],
      default: '',
    },
    label: {
      type: String,
      default: '',
    },
    placeholder: {
      type: String,
      default: '',
    },
    required: {
      type: Boolean,
      default: false,
    },
    v: {
      type: Object,
      default: null,
    },
    mask: {
      type: String,
      default: '',
    },
    helpText: {
      type: String,
      default: '',
    },
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    model: {
      get () {
        return this.value
      },
      set (value) {
        this.v.$touch()
        this.$emit('input', value)
      },
    },
  },
  watch: {
    model (val) {
      this.$emit('input', val)
    },
  },
}
</script>
