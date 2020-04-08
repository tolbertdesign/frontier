<template>
  <div class="back-button text-left">
    <a
      href="#"
      class="text-24"
      @click="$emit('back-button', $event.target.value)"
    ><i class="fas fa-arrow-left" /></a>
  </div>
</template>

<script>
export default {
  props: {
    home_url: {
      type: String,
      default: '',
    },
  },
}

</script>
