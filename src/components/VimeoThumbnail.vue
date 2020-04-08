<template>
  <img
    :src="thumbnailImage"
    class="vimeo-thumbnail"
    alt=""
  >
</template>

<script>
/**
     * example usage
     * <vimeo-thumbnail text="{{ $testvar }}" hash="[videoHash]"></vimeo-thumbnail>
     */
export default {
  props: {
    hash: { type: String, required: true },
  },
  data: function () {
    return {
      thumbnailImage: null,
    }
  },
  mounted: function () {
    var axiosInstance = axios.create()
    delete axiosInstance.defaults.headers.common['X-CSRF-TOKEN']
    axiosInstance.get('https://vimeo.com/api/oembed.json?url=https%3A//vimeo.com/' + this.hash).then((response) => {
      this.thumbnailImage = response.data.thumbnail_url
    })
  },
}
</script>

<style scoped>
    img {
        width: 100%;
    }
</style>
