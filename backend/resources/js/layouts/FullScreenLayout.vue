<template>
  <main
    class="flex items-center justify-between w-full h-full min-h-screen bg-center bg-no-repeat bg-cover"
    :style="`background-image: url(${imgUrl}); min-height: -webkit-fill-available`"
  >
    <slot>
      <div class="border-4 border-dashed border-gray-200 rounded-lg h-96" />
    </slot>

  </main>
</template>

<script>
export default {
  name: 'FullScreenLayout',
  props: {
    imgUrl: {
      type: String,
      default: 'http://cominex.net/assets/img/background.jpg',
    },
  },
}
</script>
