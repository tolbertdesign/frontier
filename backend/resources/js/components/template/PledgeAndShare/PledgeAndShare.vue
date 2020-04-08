<template>
  <section class="bg-white px-6 max-w-sm lg:max-w-lg mx-auto">
    <div class="text-center my-4">
      <PledgeButton :participants="participants" />
      <button
        v-if="showAskPreviousSponsors"
        class="button is-medium is-secondary is-rounded is-fullwidth mb-4"
      >
        Ask Previous Sponsors
      </button>
      <button
        v-if="showPayPledgesOnline"
        class="button is-medium is-secondary is-outlined is-rounded is-fullwidth"
      >
        Pay Pledges
      </button>
    </div>

    <ShareButtons
      :participants="participants"
      :program="program"
    />
  </section>
</template>

<script>
import PledgeButton from '@/components/element/PledgeButton'
import ShareButtons from '@/components/pattern/ShareButtons'

export default {
  name: 'PledgeAndShare',
  status: 'prototype',
  release: '1.0.0',
  components: {
    PledgeButton,
    ShareButtons,
  },
  props: {
    showAskPreviousSponsors: {
      type: Boolean,
      default: false,
    },
    showPayPledgesOnline: {
      type: Boolean,
      default: false,
    },
    participants: {
      type: Array,
      default: () => [],
    },
    program: {
      type: Object,
      default: undefined,
    },
  },
}
</script>
