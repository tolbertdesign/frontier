
<template>
  <svg
    viewBox="0 0 36 36"
    class="circular-chart md:my-2 mx-auto"
  >
    <path
      class="circle-bg"
      d="M18 2.0845
                a 15.9155 15.9155 0 0 1 0 31.831
                a 15.9155 15.9155 0 0 1 0 -31.831"
    />
    <path
      :stroke-dasharray="`${value}, 100`"
      class="circle"
      d="M18 2.0845
                a 15.9155 15.9155 0 0 1 0 31.831
                a 15.9155 15.9155 0 0 1 0 -31.831"
    />
    <text
      x="18"
      y="20.35"
      class="percentage"
    >{{ value }}%</text>
  </svg>
</template>

<script>
export default {
  name: 'RingChart',
  props: {
    value: {
      type: Number,
      default: 0,
    },
  },
}
</script>
