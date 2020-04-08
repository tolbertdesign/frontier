<template>
  <div
    id="app"
    ref="gallery"
    class="scene -gallery"
  >
    <h1 ref="heading">
      Restaurants In Your Area
    </h1>
    <div
      v-for="item in food"
      :key="item.name"
      ref="itemimg"
      class="item"
      :data-key="item.name"
      @click="expand(item, $event)"
    >
      <img
        :ref="item.name"
        :src="`${item.name}.jpg`"
        :alt="item.name"
      >
      <h4>{{ item.restaurant }}</h4>
    </div>
    <AppDetails
      v-if="isShowing && !isMobile"
      :current-item="currentItem"
      :top-img="topImg"
      :rects="rects"
    />
    <AppMobiledetails
      v-if="isShowing && isMobile"
      :current-item="currentItem"
      :is-showing="isShowing"
      @closeModal="isShowing = $event"
    />
  </div>
</template>

<script>
import { TweenMax, Sine } from 'gsap'
import AppMobiledetails from '@/components/AppMobiledetails'
import AppDetails from '@/components/AppDetails'

export default {
  components: {
    AppDetails,
    AppMobiledetails,
  },
  data () {
    return {
      isShowing: false,
      isMobile: false,
      currentItem: null,
      rects: {
        first: null,
        last: null,
      },
      imgOffset: 0,
      topImg: 0,
    }
  },
  computed: {
    food () {
      return this.$store.state.food
    },
  },
  watch: {
    isShowing () {
      window.matchMedia('(min-width: 768px)').matches
        ? (this.isMobile = false)
        : (this.isMobile = true)
    },
  },
  methods: {
    expand (item, event) {
      if (window.matchMedia('(min-width: 768px)').matches) {
        const itemEl = event.target
        const elImg = this.$refs[item.name][0]
        this.rects.first = itemEl.getBoundingClientRect()
        this.rects.last = this.$refs.gallery.getBoundingClientRect()
        if (!this.isShowing) {
          this.isShowing = true
          this.currentItem = item
          this.topImg = this.$refs.gallery.scrollTop
          const deltaW = this.rects.first.left - this.rects.last.left
          const deltaH = this.rects.first.top - this.rects.last.top
          const deltaS = (this.rects.last.width - 30) / this.rects.first.width
          TweenMax.to(elImg, 0.3, {
            x: -deltaW,
            y: -deltaH,
            scale: deltaS,
            transformOrigin: '0 0',
            zIndex: 1000,
            ease: Sine.easeOut,
          })
        } else {
          TweenMax.to(elImg, 0.3, {
            x: 0,
            y: 0,
            scale: 1,
            transformOrigin: '0 0',
            zIndex: 0,
            ease: Sine.easeIn,
          })
          this.isShowing = false
          this.currentItem = null
        }
      } else {
        this.isShowing = true
        this.currentItem = item
      }
    },
  },
}
</script>

<style lang="scss">
.scene {
  display: flex;
  position: relative;
  top: 0;
  left: 0;
  width: $app-width;
  height: $app-height;
  max-height: 100%;
  &.-gallery {
    position: relative;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-start;
    > .item {
      flex-basis: 30%;
      flex-grow: 0;
      flex-shrink: 0;
      height: auto;
      min-height: $app-width / 3;
    }
  }
}
.item {
  transform-origin: top left;
  cursor: pointer;
  position: relative;
  transform-origin: 0 0;
  > img {
    height: auto;
    width: 100%;
    position: relative;
    backface-visibility: hidden;
  }
}
h4 {
  margin: 8px 0 30px;
  font-weight: normal;
}
h1 {
  text-align: center;
  width: 100%;
}
</style>
