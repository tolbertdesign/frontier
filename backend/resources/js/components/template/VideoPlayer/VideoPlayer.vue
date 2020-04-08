<template>
  <div>
    <figure class="image is-16by9 mb-4">
      <VideoIframe
        :video-id="activeVideo.external_video_id"
        :source="activeVideo.source"
      />
    </figure>
    <span
      v-if="$store.state.User.is_teacher_user && displayContentLibraryLink"
      class="hidden md:inline absolute content-library-button"
    >
      <ContentLibraryButton />
    </span>

    <BTabs
      v-model="activeTab"
    >
      <BTabItem
        v-for="(videoCollection, index) in videoCollections"
        :key="index"
      >
        <template slot="header">
          <span class="text-xl font-medium inline-block -ml-4">{{ videoCollection.title }}</span>
        </template>
        <VideoGallery
          :videos="videoCollection.videos"
          :selected-video-id="activeVideo.external_video_id"
          @videoSelected="updateActiveVideo"
        />
      </BTabItem>
    </BTabs>

    <div
      v-if="$store.state.User.is_teacher_user"
      class="md:hidden text-center"
    >
      <ContentLibraryButton />
    </div>
  </div>
</template>

<script>
import VideoGallery from '@/components/template/VideoGallery'
import ContentLibraryButton from '@/components/element/ContentLibraryButton'
import VideoIframe from '@/components/element/VideoIframe'

export default {
  name: 'VideoPlayer',
  status: 'prototype',
  release: '1.0',
  components: {
    VideoGallery,
    ContentLibraryButton,
    VideoIframe,
  },
  props: {
    videoCollections: {
      type: Array,
      default: () => [],
    },
    presetVideo: {
      type: Object,
      default: null,
    },
    displayContentLibraryLink: {
      type: Boolean,
      default: true,
    },
  },
  data () {
    return {
      activeTab: 0,
      activeVideoIndex: undefined,
      activeTabKey: undefined,
      selectedVideo: null,
    }
  },
  computed: {
    activeVideo () {
      return this.selectedVideo ? this.selectedVideo : this.presetVideo
    },
    lang () {
      return this.$store.state.lang
    },
  },
  methods: {
    updateActiveVideo (video) {
      this.selectedVideo = video
    },
  },
}
</script>

<style lang="scss">
.b-tabs {
    .tab-content {
        padding: 0;
    }
}
.content-library-button {
    right: 1.5rem;
    margin-top: 0.25rem;
}
</style>
