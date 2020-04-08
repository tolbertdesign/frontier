<template>
  <div class="alert-container">
    <AlertBar
      v-for="alert in alerts"
      :key="alert.id"
      :alert="alert"
    />
  </div>
</template>

<script>
import { mapState } from 'vuex'
import AlertBar from '@/components/AlertBar.vue'

export default {
  components: {
    AlertBar,
  },
  computed: mapState('alert', ['alerts']),
}
</script>

<style scoped>
.alert-container {
  position: fixed;
  bottom: 0;
  right: 0;
  padding-right: 40px;
}
</style>
