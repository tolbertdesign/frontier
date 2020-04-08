<template>
  <div class="alert-bar" :class="alertTypeClass">
    <p>{{ alert.message }}</p>
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  props: {
    alert: {
      type: Object,
      required: true,
    },
  },
  data () {
    return {
      timeout: null,
    }
  },
  computed: {
    alertTypeClass () {
      return `-text-${this.alert.type}`
    },
  },
  mounted () {
    this.timeout = setTimeout(() => this.remove(this.alert), 5000)
  },
  beforeDestroy () {
    clearTimeout(this.timeout)
  },

  methods: mapActions('alert', ['remove']),
}
</script>

<style scoped>
.alert-bar {
  margin: 1em 0 1em;
}
</style>
