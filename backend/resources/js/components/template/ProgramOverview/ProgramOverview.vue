<template>
  <div class="program-overview card-content">
    <VideoPlayer
      v-if="displayVideoPlayer"
      :video-collections="videoCollections"
      :preset-video="presetVideo"
      :display-content-library-link="!program.microsite.hide_character_videos"
      class="pb-8"
    />
    <div class="pb-2">
      <h2 class="text-lg sm:text-2xl font-semibold">
        {{ lang.header_overview_text_override }}
      </h2>

      <div
        class="content"
        v-html="programDescription"
      />
    </div>
  </div>
</template>

<script>
import VideoPlayer from '@/components/template/VideoPlayer'
import axios from 'axios'

export default {
  name: 'ProgramOverview',
  status: 'prototype',
  release: '1.0',
  components: { VideoPlayer },
  props: {
    program: {
      type: Object,
      default: null,
    },
  },
  data () {
    return {
      displayVideoPlayer: false,
      videosRetrieved: false,
      videoCollections: [],
      presetVideo: {},
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    programVideos () {
      return {
        name: 'program',
        title: this.lang.program_videos_title,
        url: `/v3/api/videos/program/${this.program.participants[0].id}`,
      }
    },
    characterVideos () {
      return {
        name: 'character',
        title: this.characterVideosTitle,
        url: `/v3/api/videos/character/${this.program.id}`,
      }
    },
    characterVideosTitle () {
      return this.$store.state.User.is_teacher_user ? this.lang.teacher_character_videos_title : this.lang.parent_character_videos_title
    },
    videoCategoriesArray () {
      const videoArray = [this.programVideos]

      if (!this.program.microsite.hide_character_videos) {
        this.addCharacterVideos(videoArray)
      }

      return videoArray
    },
    programOverviewText () {
      return this.program.microsite.overview_text_override
    },
    hasProgramOverviewText () {
      return typeof this.programOverviewText === 'string' && this.programOverviewText.trim() !== ''
    },
    defaultTextOverride () {
      return this.parseLanguage(
        this.$store.state.lang.overview_text_override, {
          event_name: this.program.event_name,
          unit_plural: this.program.unit.name_plural,
        },
      )
    },
    programDescription () {
      if (this.hasProgramOverviewText) {
        return this.programOverviewText
      }

      return this.defaultTextOverride
    },
  },
  created () {
    this.fetchVideos()
  },
  methods: {
    addCharacterVideos (videos) {
      this.$store.state.User.is_teacher_user ? videos.unshift(this.characterVideos) : videos.push(this.characterVideos)
    },
    fetchVideos () {
      axios.all(this.videoCategoriesArray.map(videoCategory => {
        return axios.get(videoCategory.url).then(response => {
          if (response.data && response.data.length > 0) {
            videoCategory.videos = response.data
            this.videosRetrieved = true
          }
        })
      })).then(response => {
        if (this.videosRetrieved) {
          this.setVideos()
        }
      }).catch(error => {
        console.error(error)
      })
    },
    setVideos () {
      this.videoCollections = this.videoCategoriesArray
      this.presetVideo = this.videoCollections[0].videos[0]
      this.displayVideoPlayer = true
    },
  },
}
</script>

<style lang="scss">
    .program-overview .readmore-wrapper {
        .toggled p {
            margin-bottom: 1em;
        }
        .toggled span > :last-child {
            margin-bottom: 0em;
        }
        ol, ul {
            padding-left: 40px;
            margin-top: 1em;
            margin-bottom: 1em;

            ol, ul {
                margin-top: 0em;
                margin-bottom: 0em;
            }
        }
        ul {
            list-style-type: disc;
        }
    }
</style>
