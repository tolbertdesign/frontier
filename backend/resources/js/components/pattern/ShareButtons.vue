<template>
  <div>
    <div class="flex flex-wrap justify-between content-center mt-8 lg:my-8">
      <div class="w-1/4 lg:w-3/10 flex-wrap text-center">
        <ShareButton
          :participants="participants"
          :special-urls="specialUrls"
          :has-video="hasVideo"
          :ga_site_location="ga_site_location"
          :ga_page_location="ga_page_location"
          type="facebook"
        />
      </div>

      <div class="w-1/4 lg:w-3/10 flex-wrap text-center">
        <ShareButton
          :participants="participants"
          :has-video="hasVideo"
          :ga_site_location="ga_site_location"
          :ga_page_location="ga_page_location"
          type="email"
        />
      </div>

      <div class="w-1/4 lg:w-3/10 flex-wrap text-center sms-share-btn lg:hidden">
        <ShareButton
          :participants="participants"
          :special-urls="specialUrls"
          :has-video="hasVideo"
          :program="program"
          :ga_site_location="ga_site_location"
          :ga_page_location="ga_page_location"
          type="sms"
        />
      </div>

      <div class="w-1/4 lg:w-3/10 flex-wrap text-center">
        <ShareButton
          :special-urls="specialUrls"
          :has-video="hasVideo"
          :program="program"
          :ga_site_location="ga_site_location"
          :ga_page_location="ga_page_location"
          type="link"
        />
      </div>
    </div>
    <div
      v-if="hasPreviousSponsors"
      class="flex flex-wrap justify-center content-center mt-4 pb-0 py-4 py-0 lg:my-0 border-t-2 lg:border-t-0"
    >
      <div class="flex-wrap text-center">
        <PreviousSponsorShareButton
          :participants="participants"
          :ga_site_location="ga_site_location"
          :ga_page_location="ga_page_location"
        />
      </div>
    </div>
  </div>
</template>

<script>
import ShareButton from '@/components/element/ShareButton'
import PreviousSponsorShareButton from '@/components/element/PreviousSponsorShareButton'

export default {
  name: 'ShareButtons',
  status: 'prototype',
  release: '1.0.0',
  components: {
    ShareButton,
    PreviousSponsorShareButton,
  },
  props: {
    participants: {
      type: Array,
      default: () => [],
    },
    program: {
      type: Object,
      default: undefined,
    },
    ga_page_location: {
      type: String,
      default: 'Student Card Header Section',
    },
    ga_site_location: {
      type: String,
      default: 'Parent Dashboard',
    },
  },
  data () {
    return {
      hasPreviousSponsors: false,
    }
  },
  computed: {
    hasVideo () {
      return this.participants.reduce((result, participant) => {
        const hasImage = !!participant.profile.image_name
        return result || hasImage
      }, false)
    },
    specialUrls () {
      return this.participants[0].special_urls
    },
  },
  mounted () {
    this.hasPreviousSponsors = this.$store.getters.getPreviousSponsors.length > 0
  },
}
</script>
