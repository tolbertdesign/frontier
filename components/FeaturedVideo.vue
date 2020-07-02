<template>
  <figure class="featured-video">
    <iframe
      v-if="source !== 'jwplayer'"
      :src="src"
      frameborder="0"
      webkitallowfullscreen
      mozallowfullscreen
      allowfullscreen
      allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
    />
    <div
      v-if="source === 'jwplayer'"
      :id="playerId"
      class="jwplayer_div"
      itemscope
      itemtype="https://schema.org/VideoObject"
    />
  </figure>
</template>

<script>
export default {
  name: 'FeaturedVideo',
  props: {
    videoId: {
      type: [String, Number],
      default: 'Uv-IZDxdZbM',
    },
    source: {
      type: String,
      default: 'youtube',
    },
    color: {
      type: String,
      default: 'ffffff',
    },
    autoplay: {
      type: Boolean,
      default: false,
    },
    configId: {
      type: String,
      default: 'JcxcCN5H', // for jwplayer
    },
  },
  data() {
    return {
      playerId: 'myvideo' + Math.floor(Math.random() * 100),
    }
  },
  computed: {
    src() {
      if (this.source === 'youtube') {
        if (this.autoplay) {
          return `https://www.youtube-nocookie.com/embed/${this.videoId}?autoplay=1`
        } else {
          return `https://www.youtube-nocookie.com/embed/${this.videoId}?autoplay=0`
        }
      } else if (this.source === 'jwplayer') {
        return `https://content.jwplatform.com/players/${this.videoId}-${this.configId}.html?rel=0&amp;wmode=transparent&amp;showinfo=0`
      } else {
        return `https://player.vimeo.com/video/${this.videoId}?color=${this.color}`
      }
    },
  },
  mounted() {
    if (this.source === 'jwplayer') {
      this.setupJWPlayer()
      this.setupJWPlayerTracking()
    }
  },
  methods: {
    setupJWPlayer() {
      window.jwplayer(this.playerId).setup({
        image: `https://cdn.jwplayer.com/thumbs/${this.videoId}.jpg`,
        file: `https://cdn.jwplayer.com/manifests/${this.videoId}.m3u8`,
      })
    },
    setupJWPlayerTracking() {
      let hasTrackedComplete = false
      let hasTracked25 = false
      let hasTracked50 = false
      let hasTracked75 = false
      const playerInstance = window.jwplayer(this.playerId)
      playerInstance.on('firstFrame', () => {
        hasTrackedComplete = false
        hasTracked25 = false
        hasTracked50 = false
        hasTracked75 = false
        window.dataLayer.push({
          event: 'gaEvent',
          eventCategory: 'Videos',
          eventAction: this.videoId,
          eventLabel: 'Start',
        })
      })
      playerInstance.on('complete', () => {
        if (!hasTrackedComplete) {
          hasTrackedComplete = true
          window.dataLayer.push({
            event: 'gaEvent',
            eventCategory: 'Videos',
            eventAction: this.videoId,
            eventLabel: 'Watched to End',
          })
        }
      })
      playerInstance.on('time', e => {
        if (e.position / e.duration > 0.25 && !hasTracked25) {
          hasTracked25 = true
          window.dataLayer.push({
            event: 'gaEvent',
            eventCategory: 'Videos',
            eventAction: this.videoId,
            eventLabel: '25%',
          })
        }
        if (e.position / e.duration > 0.5 && !hasTracked50) {
          hasTracked50 = true
          window.dataLayer.push({
            event: 'gaEvent',
            eventCategory: 'Videos',
            eventAction: this.videoId,
            eventLabel: '50%',
          })
        }
        if (e.position / e.duration > 0.75 && !hasTracked75) {
          hasTracked75 = true
          window.dataLayer.push({
            event: 'gaEvent',
            eventCategory: 'Videos',
            eventAction: this.videoId,
            eventLabel: '75%',
          })
        }
      })
    },
  },
}
</script>

<style>
.featured-video {
  @apply relative;
  @apply w-full;
  @apply aspect-ratio-16/9;
  @apply mb-8;
}

.featured-video iframe {
  @apply absolute;
  @apply w-full;
  @apply h-full;
  @apply top-0;
  @apply left-0;
}
</style>
