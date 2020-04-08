<template>
  <RoundedButton
    :link="`/v3/tkdashboard/?redirect=auth/login/${fr_code}/view-participant/pledge`"
    class="is-primary"
    text="Enter Pledge"
  />
</template>

<script>
import RoundedButton from '@/components/element/RoundedButton'

export default {
  name: 'PledgeButton',
  status: 'prototype',
  release: '1.0.0',
  components: {
    RoundedButton,
  },
  props: {
    participants: {
      type: Array,
      default: () => [],
    },
  },
  computed: {
    fr_code () {
      return this.participants.find(participant => participant.deleted !== 1).fr_code
    },
  },
}
</script>
