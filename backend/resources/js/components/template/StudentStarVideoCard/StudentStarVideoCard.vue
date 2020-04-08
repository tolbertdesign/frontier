<template>
  <div class="flex w-full">
    <div class="mr-1 sm:mr-4">
      <a :href="editProfileLink">
        <AvatarImage
          :alt="participant.first_name"
          :src="avatarSrc"
        />
      </a>
    </div>
    <div class="flex-1 self-center">
      <h2>
        {{ participant.first_name }}
      </h2>
    </div>
    <div class="self-center text-right">
      <span
        v-if="inProgress"
        class="font-bold text-tertiary"
      >
        {{ lang.student_star_video.video_in_progress }}
      </span>
      <span
        v-else-if="readyToShare"
        class="font-bold text-primary"
      >
        {{ lang.student_star_video.ready_to_share }}
      </span>
      <RouterLink
        v-else
        :to="{ name: 'edit-participant', params: {id: participant.id} }"
        class="inline-block py-1 sm:py-2 px-4 sm:px-6 text-white hover:text-white shadow font-semibold rounded-full bg-secondary whitespace-no-wrap"
        @click.native="gaEvent('Parent Dashboard', 'Student Star Video Section', 'Upload Photo')"
      >
        {{ lang.student_star_video.upload_photo }}
      </RouterLink>
    </div>
  </div>
</template>

<script>
export default {
  name: 'StudentStarVideoCard',
  props: {
    participant: {
      type: Object,
      default: function () {
        return {}
      },
    },
  },
  computed: {
    avatarSrc () {
      return this.participant.profile.image_name == null ? '/v3-assets/dashboard/images/dashboard-avatar.svg' : this.avatarImgSrc
    },
    avatarImgSrc () {
      return this.$store.getters.avatarPath + this.participant.profile.image_name
    },
    editProfileLink () {
      return '/v3/tkdashboard/?redirect=' + encodeURI('auth/login/' + this.participant.fr_code + '/edit-personalize')
    },
    inProgress () {
      return this.participant.profile.image_name !== null && this.participant.profile.video_url == null
    },
    readyToShare () {
      return this.participant.profile.image_name !== null && this.participant.profile.video_url !== null
    },
    lang () {
      return this.$store.state.lang
    },
  },
}
</script>
