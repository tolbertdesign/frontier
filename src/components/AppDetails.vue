<template>
  <div
    ref="details"
    class="scene -detail"
    :style="{ top: topAmt + 'px' }"
  >
    <div class="detail">
      <div class="content">
        <h2
          ref="title"
          class="title"
        >
          {{ currentItem.restaurant }}
        </h2>
        <div class="tags">
          <span
            v-for="tag in currentItem.tags"
            :key="tag"
          >
            {{ tag }}
          </span>
        </div>
        <p
          ref="desc"
          class="description"
        >
          {{ currentItem.desc }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import { TweenMax, Sine } from 'gsap'
import { lettering } from '@/use/lettering'
import { preventscroll } from '@/use/preventscroll'

export default {
  props: {
    currentItem: {
      type: Object,
      required: true,
    },
    rects: {
      type: Object,
      required: true,
    },
    topImg: {
      type: Number,
      required: true,
    },
  },
  hooks () {
    preventscroll()
    lettering()
  },
  computed: {
    topAmt () {
      if (window.matchMedia('(min-width: 768px)').matches) {
        // tablet + above
        return this.topImg + 500
      } else {
        // mobile
        // compensate for the top nav and adjusting the image
        const topMargin = this.rects.last.top > 0 ? 0 : 110
        return window.pageYOffset - topMargin + this.rects.last.width - 280
      }
    },
  },
  mounted () {
    this.fadeIn()
  },
  methods: {
    fadeIn () {
      TweenMax.fromTo(
        '.-detail',
        0.3,
        {
          opacity: 0,
        },
        {
          opacity: 1,
          ease: Sine.easeOut,
        },
      )
    },
  },
}
</script>

<style lang="scss">
.scene.-detail {
  position: absolute;
  max-height: 1000px;
  overflow-y: auto !important;
  z-index: 10000;
}
.detail {
  color: white;
  width: $app-width;
  height: $app-height;
  transform-origin: top left;
  display: flex;
  flex-direction: column;
  .content {
    flex: 1 0 auto;
    padding: 2rem 1.5rem;
    * {
      margin-bottom: 1rem;
    }
    .title {
      font-size: 2rem;
      margin-top: 0;
      text-transform: uppercase;
      span {
        perspective: 500;
        perspective-origin: 50% 50%;
        transform-style: preserve-3d;
      }
    }
    .word,
    .char {
      margin-bottom: 0;
    }
    .creator {
      opacity: 0.6;
      margin-top: -0.5rem;
    }
    .description {
      line-height: 1.5;
    }
  }
}
@media only screen and (min-width: 768px) {
  .scene {
    overflow-y: scroll;
  }
  .content {
    background: #1d1f20;
  }
}
</style>
