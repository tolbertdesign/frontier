<template>
  <div class="bg-grey-lightest pb-2 mx-auto shadow-md rounded-xl max-w-xs">
    <div
      class="modal-card"
      style="width: auto;"
    >
      <button
        type="button"
        class="modal-close inner-modal-close modal-close-btn-position is-large absolute bg-transparent mb-4"
        aria-label="close"
        @click="cancel"
      >&times;</button>

      <p class="text-center text-lg leading-normal mt-18 max-w-xs">
        {{ lang.about_to_delete }}
      </p>
      <p class="text-center font-semibold text-lg leading-normal mt-4 mb-6">
        {{ lang.continue }}
      </p>

      <div
        class="controls px-6"
      >
        <div class="text-center mt-5 pb-1">
          <div class="max-w-md mx-0 md:mx-auto">
            <div>
              <button
                type="submit"
                class="button is-danger is-rounded inline-block mb-4 w-64 shadow"
                @click="confirmed"
              >
                {{ lang.delete }}
              </button>
              <br>
              <button
                type="button"
                class="button border-grey-dark text-grey-dark is-rounded inline-block mb-4 w-64 is-outlined shadow"
                @click="cancel"
              >
                {{ lang.cancel }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Blur from '@/mixins/Blur'
export default {
  name: 'ConfirmationModal',
  status: 'prototype',
  release: '1.0.0',
  mixins: [Blur],
  computed: {
    lang () {
      return this.$store.state.lang
    },
  },
  methods: {
    cancel () {
      this.$emit('close')
      this.unBlur()
      return false
    },
    confirmed () {
      this.$emit('close')
      this.unBlur()
      this.$emit('confirmed')
    },
  },
}
</script>
