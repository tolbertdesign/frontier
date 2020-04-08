<template>
  <div class="bg-transparent flex items-center flex-1">
    <img
      v-if="hasSchoolImage"
      :src="imgSrc"
      :alt="program.microsite.school_image_name"
      class="rounded-full shadow-md w-16 h-16 lg:w-24 lg:h-24 mb-0 mr-8"
    >
    <div class="text-white lg:w-2/3">
      <!-- Display longer header text when screen is larger than mobile -->
      <span
        :title="program.event_name"
        class="text-xl sm:text-2xl lg:text-4xl font-medium leading-tight is-hidden-mobile"
      >
        {{ displayProgramEventNameDesktop }}
      </span>

      <!-- Display shorter header text for mobile -->
      <span
        :title="program.event_name"
        class="text-xl sm:text-2xl lg:text-4xl font-medium leading-tight is-hidden-tablet"
      >
        {{ displayProgramEventNameMobile }}
      </span>
      <EventInfo
        :funrun-date="funRunIgnoreTimeZone"
        class="hidden lg:flex"
      />
    </div>
  </div>
</template>

<script>
import EventInfo from '@/components/EventInfo'

export default {
  name: 'ProgramHeader',
  status: 'prototype',
  release: '1.0.0',
  components: {
    EventInfo,
  },
  props: {
    program: {
      type: Object,
      default: null,
    },
  },
  computed: {
    hasSchoolImage () {
      return !!this.program.microsite.school_image_name
    },
    imgSrc () {
      return `https://${this.$store.state.s3Bucket}.s3.amazonaws.com/program_logos/${this.program.microsite.school_image_name}`
    },
    displayProgramEventNameDesktop () {
      if (this.program.event_name && this.program.event_name.length > 70) {
        return this.program.event_name.substring(0, 70) + '...'
      }

      return this.program.event_name
    },
    displayProgramEventNameMobile () {
      if (this.program.event_name && this.program.event_name.length > 50) {
        return this.program.event_name.substring(0, 50) + '...'
      }

      return this.program.event_name
    },
    funRunIgnoreTimeZone () {
      return new Date(this.program.fun_run.replace(/-/g, '/').replace(/T.+/, ''))
    },
  },
}
</script>
