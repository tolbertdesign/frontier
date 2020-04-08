<template>
  <div>
    <BCollapse
      :open="isOpen"
      class="card shadow-none border-t-2 border-grey-light"
    >
      <button
        slot="trigger"
        slot-scope="props"
        class="flex items-baseline w-full justify-between mb-px py-4 sm:py-4 px-4 md:px-4 cursor-pointer shadow-none focus:outline-none"
        @click="collapseClick"
      >
        <slot name="title">
          <p class="text-xl sm:text-2xl font-semibold">
            <span class="pl-1">{{ title }}</span>
          </p>
        </slot>
        <slot name="toggle">
          <span class="flex cursor-pointer items-center justify-center text-grey-dark">
            <FontAwesomeIcon :icon="props.open ? 'chevron-up' : 'chevron-down'" />
          </span>
        </slot>
      </button>
      <slot>
        <div class="p-2">
          <div class="modal-card-body bg-white p-4 md:p-6 text-sm sm:text-base md:text-lg">
            <p class="mb-4">
              {{ content }}
            </p>
          </div>
        </div>
      </slot>
    </BCollapse>
  </div>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
export default {
  name: 'Accordion',
  status: 'prototype',
  release: '1.0.0',
  components: {
    FontAwesomeIcon,
  },
  props: {
    title: {
      type: String,
      default: '',
    },
    content: {
      type: String,
      default: '',
    },
    isOpen: {
      type: Boolean,
      default: false,
    },
    shouldReslick: {
      type: Boolean,
      default: false,
    },
  },
  methods: {
    collapseClick () {
      if (this.shouldReslick) {
        this.$nextTick(
          () => {
            if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0) {
              var evt = document.createEvent('UIEvents')
              evt.initUIEvent('reslicked', true, false, window, 0)
              window.dispatchEvent(evt)
            } else {
              window.dispatchEvent(new Event('reslicked'))
            }
          },
        )
      }
    },
  },
}
</script>
