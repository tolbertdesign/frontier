<template>
  <div class="max-w-4xl mx-auto w-full">
    <div class="pr-8">
      <span>{{ $store.state.lang.event_info.event_date }}</span> <b>{{ eventDate }}</b>
    </div>
    <div v-if="daysRemaining && displayDaysRemaining">
      <b>{{ daysRemaining }}</b> {{ $store.state.lang.event_info.days_remaining }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'EventInfo',
  status: 'prototype',
  release: '1.0.0',
  props: {
    funrunDate: {
      type: Date,
      default: null,
    },
    displayDaysRemaining: {
      type: Boolean,
      default: true,
    },
  },
  computed: {
    eventDate () {
      let month = this.funrunDate.getMonth() + 1
      let day = this.funrunDate.getDate()
      if (month < 10) {
        month = '0' + month
      }
      if (day < 10) {
        day = '0' + day
      }
      return month + '/' + day + '/' + this.funrunDate.getFullYear()
    },
    daysRemaining () {
      const now = new Date()
      const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())
      const days = Math.ceil((this.funrunDate - today.getTime()) / (1000 * 60 * 60 * 24))
      if (days < 0) {
        return 0
      }

      return days
    },
  },
}
</script>
