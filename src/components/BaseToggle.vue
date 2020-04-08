<template>
  <span
    :class="{
      'bg-gray-200': !value,
      'bg-orange-400': value,
    }"
    class="relative inline-block flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:shadow-outline"
    role="checkbox"
    tabindex="0"
    :aria-checked="value.toString()"
    @click="toggle"
    @keydown.space.prevent="toggle"
  >
    <span
      aria-hidden="true"
      :class="{
        'translate-x-5': value,
        'translate-x-0': !value,
      }"
      class="inline-block h-5 w-5 rounded-full bg-white shadow transform transition ease-in-out duration-200"
    />
  </span>
</template>

<script>
export default {
  name: 'BaseToggle',
  data () {
    return {
      value: true,
    }
  },
  methods: {
    toggle () {
      this.value = !this.value
    },
  },
}
</script>
