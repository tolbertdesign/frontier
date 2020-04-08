<template>
  <div ref="themeToggle" class="flex items-center">
    <button
      id="light"
      class="px-3 py-2 rounded-md text-sm leading-5 font-medium focus:outline-none transition duration-150 ease-in-out"
      @click="setTheme"
    >Light</button>

    <button
      id="dark"
      class="px-3 py-2 rounded-md text-sm leading-5 font-medium focus:outline-none transition duration-150 ease-in-out"
      @click="setTheme"
    >Dark</button>
  </div>
</template>

<script>
export default {
  name: 'ThemeToggle',
  data () {
    return {
      theme: null,
    }
  },
  mounted () {
    this.theme = localStorage.getItem('theme')

    if (this.theme) {
      document.body.classList.add(this.theme)
    }
  },
  methods: {
    setTheme (event) {
      const newTheme = event.target.id
      document.body.classList.replace(this.theme, newTheme)
      this.theme = newTheme
      localStorage.setItem('theme', newTheme)
    },
  },
}
</script>
