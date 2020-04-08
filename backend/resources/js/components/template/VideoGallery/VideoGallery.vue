<template>
  <div class="lg:flex lg:flex-wrap -mx-2">
    <div
      v-for="(video, index) in videos"
      :key="index"
      class="p-2 lg:w-1/2"
    >
      <article
        :class="{'border-secondary border-2': selectedVideoId == video.external_video_id}"
        class="media border border-light hover:border-secondary cursor-pointer"
        @click="selectVideo(video)"
      >
        <button>
          <figure
            class="relative media-left mr-0"
          >
            <figure
              :style="`background-image: url('${video.thumbnail}'); background-repeat: round;`"
              class="image is-16by9 w-32 sm:w-48"
            />
            <div
              class="absolute m-auto text-center w-1/2"
              style="top:50%; left:50%; transform:translate(-50%,-50%)"
            >
              <FontAwesomeIcon
                :style="{ background: 'white', borderRadius: '50%', border: 'transparent' }"
                icon="play-circle"
                size="2x"
              />
            </div>
          </figure>
        </button>
        <div class="media-content p-2 md:p-4">
          <h3 class="text-sm sm:text-base font-semibold">
            {{ video.description }}
          </h3>
        </div>
      </article>
    </div>
  </div>
</template>

<script>
export default {
  name: 'VideoGallery',
  props: {
    videos: {
      type: Array,
      default: () => [],
    },
    selectedVideoId: {
      type: [String, Number],
      default: 0,
    },
  },
  methods: {
    selectVideo (video) {
      this.$emit('videoSelected', video)
    },
  },
}
</script>
