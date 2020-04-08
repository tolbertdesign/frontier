<template>
  <div>
    <vue-particles
      color="#ffffff"
      :particle-opacity="0.7"
      lines-color="#ffffff"
      :particles-number="80"
      shape-type="circle"
      :particle-size="5"
      :lines-width="2"
      :line-linked="true"
      :line-opacity="0.4"
      :lines-distance="150"
      :move-speed="3"
      :hover-effect="true"
      hover-mode="grab"
      :click-effect="true"
      click-mode="push"
    />
    <main
      class="flex items-center justify-between w-full h-full min-h-screen bg-center bg-no-repeat bg-cover"
      :style="`background-image: url(${imgUrl}); min-height: -webkit-fill-available`"
    >
      <slot>
        <div class="border-4 border-dashed border-gray-200 rounded-lg h-96" />
      </slot>
    </main>
  </div>

</template>

<script>
export default {
  name: 'FullScreenLayout',
  props: {
    imgUrl: {
      type: String,
      default: '/img/hand_stack_background.jpg',
    },
  },
}
</script>
