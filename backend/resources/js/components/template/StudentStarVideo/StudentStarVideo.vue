<template>
  <div class="student-star-video card-content py-4 px-0">
    <div class="px-8">
      <Slick
        v-if="participantVideoIds.length"
        ref="slick"
        :key="slickRefreshKey"
        :options="slickOptions"
        @beforeChange="slickBeforeChange()"
      >
        <div
          v-for="(videoId, index) in participantVideoIds"
          :key="index"
        >
          <VideoIframe
            v-if="videoId"
            :video-id="videoId"
            source="jwplayer"
          />
        </div>
      </Slick>
      <figure
        v-else
        class="image is-16by9 mb-8"
      >
        <VideoIframe :video-id="videoId" />
      </figure>

      <h2 class="text-lg font-semibold">
        {{ lang.student_star_video.get_pledges }}
      </h2>

      <p
        v-if="canShare"
        class="mb-8"
      >
        {{ lang.student_star_video.can_share_msg }}
      </p>

      <p
        v-else
        class="mb-8"
      >
        {{ lang.student_star_video.upload_msg }}

      </p>
    </div>
    <div class="grid mb-10 px-8 mx-auto">
      <div
        v-for="participant in program.participants"
        :key="participant.id"
        class="student-info w-full p-2 sm:p-4 relative has-background-white-bis border rounded-lg mb-4"
      >
        <StudentStarVideoCard :participant="participant" />
      </div>
    </div>

    <div
      v-if="canShare"
      class="mx-auto max-w-sm lg:max-w-lg text-center"
    >
      <h2 class="text-xl font-semibold">
        {{ lang.share_pledge_page }}
      </h2>
      <h3 class="mb-4">
        {{ lang.every_share_can }}
      </h3>
      <ShareButtons
        :program="program"
        :participants="program.participants"
        ga_site_location="Parent Dashboard"
        ga_page_location="Student Star Video Section"
      />
    </div>
  </div>
</template>

<script>
import ShareButtons from '@/components/pattern/ShareButtons'
import StudentStarVideoCard from '@/components/template/StudentStarVideoCard'
import Slick from 'vue-slick'

export default {
  name: 'ShareStudentStarVideo',
  status: 'prototype',
  release: '1.0.0',
  components: {
    ShareButtons,
    StudentStarVideoCard,
    Slick,
  },
  props: {
    program: {
      type: Object,
      default: null,
    },
    videoId: {
      type: [String, Number],
      default: '383087736',
    },
  },
  data () {
    return {
      slickOptions: {
        slidesToShow: 1,
        dots: true,
        autoplay: false,
        arrows: true,
        mobileFirst: true,
        prevArrow: '<button type="button" class="slick-prev"><i class=\'fas fa-chevron-left\'></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class=\'fas fa-chevron-right\'></i></button>',
      },
      slickRefreshKey: 0,
      slickWatcher: null,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    canShare () {
      return this.program.participants
        .find(participant => participant.profile.image_name !== null)
    },
    participantVideoIds () {
      return this.program.participants
        .filter(participant => participant.profile.video_url != null)
        .map(participant => participant.profile.video_url)
    },
  },
  mounted () {
    // Force refresh Slick when going between pages
    this.$nextTick(() => {
      this.slickWatcher = this.$store.watch((state, getters) => state.activeTab, (newVal, oldVal) => {
        this.slickRefreshKey += 1
      })
    })
    window.addEventListener('reslicked', this.reSlick)
  },
  beforeDestroy () {
    // Prevent watcher memory leak
    if (this.slickWatcher !== null) {
      this.slickWatcher()
    }
    window.removeEventListener('reslicked', this.reSlick)
  },

  methods: {
    slickBeforeChange () {
      this.pauseAllJWPlayers()
    },
    pauseAllJWPlayers () {
      let playerIndex = 0
      while (window.jwplayer(playerIndex).play) {
        if (window.jwplayer(playerIndex).getState() === 'playing') {
          window.jwplayer(playerIndex).pause()
        }
        playerIndex++
      }
    },
    next () {
      this.$refs.slick.next()
    },
    prev () {
      this.$refs.slick.prev()
    },
    reSlick () {
      if (this.$refs.slick) {
        this.$refs.slick.reSlick()
      }
    },
  },
}
</script>

<style lang="scss">
.student-star-video .grid {
    display: grid;
    grid-gap: 1rem;
    grid-template-columns: repeat(auto-fit);

    @media (min-width: 576px) {
        grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
    }
}
.student-star-video .slick-prev,
.student-star-video .slick-next { font-size: initial; color: currentColor }
.student-star-video .slick-dots li button:before { font-size: 3rem }
</style>
