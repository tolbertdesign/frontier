<template>
  <div>
    <button @click.prevent="toggleSlideOverState">Toggle State</button>
    <SlideOver
      :title="'This is a title'"
      :sub-title="'This is a sub title.'"
      :cancel-text="'Cancel'"
      :save-text="'Save'"
      :open="slideOverOpen"
      @changed="setSlideOverState"
      @save="save"
    >
      <template v-slot:contents>
        <!-- content goes here -->
      </template>
    </SlideOver>
  </div>
</template>

<script>
export default {
  data() {
    return {
      slideOverOpen: false,
    }
  },
  methods: {
    setSlideOverState(state) {
      this.slideOverOpen = state
    },
    toggleSlideOverState() {
      this.slideOverOpen = !this.slideOverOpen
    },
    save() {},
  },
}
</script>
