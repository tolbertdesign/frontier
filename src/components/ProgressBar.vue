<template>
  <div
    :class="['progress-bar', {
      'is-hidden': hidden,
      'has-error': error,
    }]"
    :style="{ 'width': `${percent}%` }"
  />
</template>

<script>
export default {
  data () {
    return {
      hidden: true,
      percent: 0,
      error: false,
    }
  },
  methods: {
    start () {
      this.hidden = false
      this.error = false
      this.percent = 0
      this.timer = setInterval(() => {
        this.percent++
      }, 100)
    },
    finish () {
      this.percent = 100
      this.hidden = true
      clearInterval(this.timer)
    },
    fail () {
      this.error = true
      this.percent = 100
    },
  },
}
</script>
