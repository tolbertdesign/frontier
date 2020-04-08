<template>
  <div class="max-w-lg mx-auto p-4 my-2 border border-grey-light rounded-lg shadow">
    <div class="media p-4">
      <div class="media-left">
        <AvatarImage
          :alt="participant.first_name"
          :src="avatarSrc"
        />
      </div>
      <div class="media-content self-center text-xl">
        <h2 class="text-base sm:text-xl font-dark text-black">
          {{ participant.first_name }}
        </h2>
        <h3 class="sm:text-sm text-xs mb-2 capitalize">
          {{ unit.name_plural }}
        </h3>
      </div>
      <div class="media-right pt-2 self-start has-text-right text-base sm:text-2xl">
        <UnitsForm
          :participant-user-id="participant.id"
          :units="participant.laps"
          :unit-name-plural="unit.name_plural"
          :unit-max="unitMax"
          :can-edit="canEdit"
        />
      </div>
    </div>
  </div>
</template>

<script>
import UnitsForm from '@/components/template/UnitsForm'
import AvatarImage from '@/components/element/AvatarImage'

export default {
  name: 'FinishLineParticipantCard',
  status: 'prototype',
  release: '1.0.0',
  components: {
    UnitsForm,
    AvatarImage,
  },
  props: {
    participant: {
      type: Object,
      default: () => {},
    },
    unit: {
      type: Object,
      default: () => {},
    },
    unitMax: {
      type: Number,
      default: 35,
    },
    canEdit: {
      type: Boolean,
      default: true,
    },
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    avatarSrc () {
      return this.participant.profile.image_name == null ? '/v3-assets/dashboard/images/dashboard-avatar.svg' : this.avatarImgSrc
    },
    avatarImgSrc () {
      return this.$store.getters.avatarPath + this.participant.profile.image_name
    },
  },
}
</script>
