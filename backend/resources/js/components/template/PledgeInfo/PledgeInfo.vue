<template>
  <div class="pledge-info card-content">
    <div class="flex items-center justify-center mb-8">
      <button
        :disabled="hasPaidAllPledges"
        class="button font-semibold is-medium is-primary is-rounded w-333px"
        @click.prevent="payPledges"
      >
        {{ lang.pledge_info.pay_pledges }}
      </button>
    </div>

    <div
      v-if="hasPledges"
      class="grid mb-8"
    >
      <PledgeInfoCard
        v-for="pledge in pledges"
        :key="pledge.id"
        :pledges="pledge"
        :program="program"
        :class="[pledges.length === 1 ? 'mr-0 ml-0' : 'mr-auto ml-auto']"
        @pledge-updated="toast"
        @pledge-deleted="(deletePledge(pledge))"
      />
    </div>

    <div
      v-else
      class="mx-auto max-w-sm mb-8"
    >
      <div class="flex flex-col items-center shadow-md rounded-lg p-8">
        <img
          class="mb-6 w-24"
          src="/v3-assets/dashboard/images/money.svg"
        >
        <div class="text-12 font-light text-center">
          {{ lang.pledge_info.hang_tight }} <span class="font-bold capitalize">{{ lang.pledge_info.pledges }}</span> {{ lang.pledge_info.start_rolling }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PledgeInfoCard from '@/components/template/PledgeInfoCard'
import SaveSuccessModal from '@/components/template/SaveSuccessModal'

export default {
  name: 'PledgeInfo',
  status: 'prototype',
  release: '1.0.0',
  components: {
    PledgeInfoCard,
  },
  props: {
    program: {
      type: Object,
      default: null,
    },
  },
  data () {
    return {
      isFlipped: false,
      pledgeStatusIdsWithPayment: [3, 8],
      pledgesToDisplay: [],
      update: 1,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    hasPaidAllPledges () {
      return this.program.participants
        .map(participant => participant.participant_info.pledges.map(pledge => pledge.pledge_status_id))
        .flat(1)
        .every((pledgeStatusId) => this.pledgeStatusIdsWithPayment.includes(pledgeStatusId))
    },
    hasPledges () {
      return this.pledges.length > 0
    },
    pledges () {
      if (this.update > 0) {
        const pledges = this.program.participants
          .map(this.mapPledgesWithParticipant)
          .flat(1)
          .reduce(this.groupByFamilyPledgeId, {})
        return this.convertObjectToArray(pledges)
          .sort(this.sortByDate)
      }
    },
  },
  methods: {
    toast () {
      this.$buefy.modal.open({
        parent: this,
        component: SaveSuccessModal,
        hasModalCard: true,
        canCancel: false,
        props: {
          title: this.lang.edit_profile.saved_successfully,
          duration: 2000,
        },
      })
    },
    mapPledgesWithParticipant (participant) {
      return participant.participant_info.pledges.map((pledge) => {
        pledge.participant = participant
        pledge.laps = participant.laps
        return pledge
      })
    },
    convertObjectToArray (object) {
      return Object.entries(object).map(entry => entry[1])
    },
    groupByFamilyPledgeId (pledges, pledge) {
      const id = pledge.family_pledge_id || pledge.id
      pledges[id] = pledges[id] || []
      pledges[id].push(pledge)
      return pledges
    },
    sortByDate (pledgesA, pledgesB) {
      return new Date(pledgesA[0].ts_entered) - new Date(pledgesB[0].ts_entered)
    },
    payPledges () {
      this.gaEvent('Parent Dashboard', 'Pledges', 'Pay Pledges')
      window.location.href = '/v3/tkdashboard?redirect=home/payment'
    },
    deletePledge (pledge) {
      this.$store.commit('DELETE_PLEDGE', pledge[0])
      this.update++ // Increment update value to preserve reactivity for pledges
    },
  },
}
</script>
