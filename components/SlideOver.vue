<template>
  <div>
    <transition
      enter-active-class="transition duration-500 ease-in-out transform sm:duration-700"
      enter-class="opacity-0"
      enter-to-class="opacity-75"
      leave-active-class="transition duration-500 ease-in-out transform sm:duration-700"
      leave-class="opacity-75"
      leave-to-class="opacity-0"
      @after-enter="afterEnter"
    >
      <div
        v-show="open"
        class="fixed inset-0 bg-gray-800 opacity-75"
        @click.prevent="toggle"
      ></div>
    </transition>
    <section class="fixed inset-y-0 right-0 flex max-w-full pl-16">
      <transition
        enter-active-class="transition duration-500 ease-in-out transform sm:duration-700"
        enter-class="translate-x-full"
        enter-to-class="translate-x-0"
        leave-active-class="transition duration-500 ease-in-out transform sm:duration-700"
        leave-class="translate-x-0"
        leave-to-class="translate-x-full"
      >
        <div v-show="open" class="w-screen max-w-md">
          <div
            class="flex flex-col h-full bg-white divide-y divide-gray-200 shadow-xl"
          >
            <div class="flex-1 h-0 overflow-y-auto">
              <header class="px-4 py-6 space-y-1 bg-indigo-700 sm:px-6">
                <div class="flex items-center justify-between space-x-3">
                  <h2 class="text-lg font-medium leading-7 text-white">
                    {{ title }}
                  </h2>
                  <div class="flex items-center h-7">
                    <button
                      aria-label="Close panel"
                      class="text-indigo-200 transition duration-150 ease-in-out hover:text-white"
                      @click.prevent="toggle"
                    >
                      <svg
                        class="w-6 h-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
                <div>
                  <p class="text-sm leading-5 text-indigo-300">
                    {{ subTitle }}
                  </p>
                </div>
              </header>
              <div class="flex flex-col justify-between flex-1">
                <div class="p-4 divide-y divide-gray-200 sm:p-6">
                  <slot name="contents"></slot>
                </div>
              </div>
            </div>
            <div class="flex justify-end flex-shrink-0 px-4 py-4 space-x-4">
              <span v-if="cancelText" class="inline-flex rounded-md shadow-sm">
                <button
                  type="button"
                  class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800"
                  @click.prevent="toggle"
                >
                  {{ cancelText }}
                </button>
              </span>
              <span
                v-if="saveText"
                class="inline-flex ml-2 rounded-md shadow-sm"
                @click.prevent="save"
              >
                <button
                  type="submit"
                  class="inline-flex justify-center px-4 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700"
                >
                  {{ saveText }}
                </button>
              </span>
            </div>
          </div>
        </div>
      </transition>
    </section>
  </div>
</template>

<script>
export default {
  props: {
    open: {
      type: Boolean,
      default: false,
    },
    title: {
      type: String,
      default: '',
    },
    subTitle: {
      type: String,
      default: '',
    },
    cancelText: {
      type: String,
      default: '',
    },
    saveText: {
      type: String,
      default: '',
    },
  },
  methods: {
    toggle() {
      this.$emit('changed', !this.open)
    },
    afterEnter(el) {
      el.classList.add('opacity-75')
    },
    save() {
      this.$emit('save')
    },
  },
}
</script>
