<template>
  <span ref="actionButton" class="relative z-0 inline-flex shadow-sm">
    <button
      type="button"
      class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
    >
      Save changes
    </button>
    <span class="-ml-px relative block">
      <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150" @click="open = !open">
        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
      </button>
      <transition
        enter-active-class="transition ease-out duration-100"
        enter-class="opacity-0 scale-95"
        enter-to-class="opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-class="opacity-100 scale-100"
        leave-to-class="opacity-0 scale-95"
      >
        <div
          v-show="open"
          style="display: none"
          class="transform origin-top-right absolute right-0 mt-2 -mr-1 w-56 rounded-md shadow-lg"
        >
          <div class="rounded-md bg-white shadow-xs">
            <div class="py-1">
              <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Save and schedule
              </a>
              <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Save and publish
              </a>
              <a href="#" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Export PDF
              </a>
            </div>
          </div>
        </div>
      </transition>
    </span>
  </span>
</template>

<script>
export default {
  name: 'ActionButton',
  data () {
    return {
      open: false,
    }
  },
  mounted () {
    document.addEventListener('click', event => {
      event.stopPropagation()
      if (!this.$refs.actionButton.contains(event.target)) {
        this.open = false
      }
    })
  },
}
</script>

<style lang="scss" scoped>

</style>
