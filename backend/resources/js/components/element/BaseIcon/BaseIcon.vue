<template>
  <div class="icon-wrapper">
    <svg
      :width="width"
      :height="height"
      v-bind="$attrs"
      class="icon"
      v-on="$listeners"
    >
      <use
        v-bind="{
          'xlink:href': '/v3-assets/dashboard/icons.svg#' + name,
        }"
      />
    </svg>
    <slot />
  </div>
</template>

<script>
export default {
  name: 'BaseIcon',
  status: 'prototype',
  release: '1.0.0',
  inheritAttrs: false,
  props: {
    name: {
      type: String,
      default: '',
    },
    width: {
      type: [Number, String],
      default: 24,
    },
    height: {
      type: [Number, String],
      default: 24,
    },
  },
}
</script>
