<template>
  <div class="share-button flex flex-col">
    <button
      :class="['share-button icon-above text-white shadow rounded-full px-8 font-normal py-2 cursor-pointer inline-block text-lg hover:text-white bg-secondary', config.className]"
      @click="clicked"
    >
      <FontAwesomeIcon
        :icon="config.icon"
        class="text-5xl fa-w-20"
      />
      {{ config.label }}
    </button>
  </div>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

export default {
  name: 'PreviousSponsorShareButton',
  status: 'prototype',
  release: '1.0.0',
  componentns: {
    FontAwesomeIcon,
  },
  props: {
    participants: {
      type: Array,
      default: () => [],
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
  computed: {
    config () {
      return {
        icon: 'users',
        label: this.lang.view_previous_sponsors_button,
        className: 'bg-secondary view-previous-sponsors',
      }
    },
    lang () {
      return this.$store.state.lang
    },
  },
  methods: {
    gaTrack () {
      this.gaEvent(this.ga_site_location, this.ga_page_location, 'Share Button: view-previous-sponsors')
    },
    clicked (event) {
      const participantUserId = this.getSmallestParticipantId()
      this.$router.push({
        name: 'easy-emailer',
        params: {
          participantUserId: participantUserId,
        },
      })
    },
    getSmallestParticipantId () {
      const participantIds = this.participants.map(obj => obj.id)
      return Math.min(...participantIds)
    },
  },
}
</script>
