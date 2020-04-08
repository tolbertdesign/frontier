<template>
  <div>
    <div
      :class="{ toggled: toggled }"
      class="readmore"
    >
      <span
        v-if="!limitHeight"
        v-html="!toggled && canTruncateBasedOnLimit() ? truncatedText : text"
      />
      <span
        v-if="limitHeight"
        :style="{ height: limit + 'em' }"
        v-html="text"
      />
      <a
        v-if="canTruncateBasedOnLimit()"
        href="javascript:void(0)"
        @click="toggle"
      >
        {{ toggled ? lessText : moreText }}
      </a>
    </div>
  </div>
</template>

<script>
/**
     * example usage
     * <readmore-component text="{{ $testvar }}" more-text="Read More" less-text="Read Less"></readmore-component>
     */
export default {
  name: 'Readmore',
  props: {
    text: { type: String, required: true },
    limit: { type: Number, default: 255 },
    limitHeight: { type: Boolean, default: false },
    moreText: { type: String, default: 'Show More' },
    lessText: { type: String, default: 'Show Less' },
  },
  data () {
    return {
      toggled: false,
    }
  },
  computed: {
    truncatedText () {
      return this.text.substring(0, this.limit) + '...'
    },
  },
  methods: {
    toggle () { this.toggled = !this.toggled },
    canTruncateBasedOnLimit () {
      return this.text.length > this.limit
    },
  },
}
</script>
<style>
.readmore span {
    display: block;
    overflow: hidden;
}

.readmore.toggled span {
    height: auto !important;
}
</style>
