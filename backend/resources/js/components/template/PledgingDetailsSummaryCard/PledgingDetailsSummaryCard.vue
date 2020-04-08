<template>
  <div class="text-sm">
    <div>
      <div class="flex justify-between border-b-2">
        <div>{{ lang.total_pledged_amount }}</div>
        <div>
          ${{ currency(allPledgingTotal) }}
        </div>
      </div>
      <div class="flex justify-between border-b-2 border-grey-darkest">
        <div>
          {{ lang.total_payments_received }}

          <span
            v-tooltip="{
              classes: ['info', 'wide'],
              content: lang.total_payments_received_tooltip,
              placement: 'auto-start',
              trigger: 'hover click focus'
            }"
          >
            <i
              class="far fa-info-circle"
            />
          </span>
        </div>
        <div>
          ${{ currency(allPaymentsTotal) }}
        </div>
      </div>
      <div class="flex justify-between items-baseline text-base">
        <span>{{ lang.outstanding_pledges_due }}</span>
        <div>
          <span class="font-bold">${{ currency(allOutstandingTotal) }}</span>
        </div>
      </div>
    </div>
    <div
      v-if="isOpen"
      class="border-t mt-5"
    >
      <div
        v-for="(participant, index) in participants"
        :key="index"
        class="mt-5"
      >

        <div class="flex items-center">
          <AvatarImage
            :alt="participant.first_name"
            :src="avatarSrc(participant)"
          />
          <div class="ml-3 text-lg">
            {{ participant.first_name }}
          </div>
        </div>

        <div class="mt-4 flex justify-between border-b-2 border-grey-darkest capitalize">
          <div>{{ parseLanguage(lang.units_completed, {units: unit.name_plural}) }}</div>
          <div>{{ participant.laps }}</div>
        </div>

        <div
          v-if="flatDonations(participant.participant_info.pledges) !== 0"
          class="flex justify-between border-b-2"
        >
          <div>{{ lang.flat_donations }}</div>
          <div>${{ currency(flatDonations(participant.participant_info.pledges)) }}</div>
        </div>
        <div
          v-if="ppuDonations(participant.participant_info.pledges, participant.laps) !== 0"
          class="flex justify-between border-b-2 capitalize"
        >
          <div>{{ lang.pledging }} {{ unit.modifier }} {{ unit.name }} ({{ participant.laps }})</div>
          <div>${{ currency(ppuDonations(participant.participant_info.pledges, participant.laps)) }}</div>
        </div>
        <div
          v-if="pledgingTotal(participant.participant_info.pledges, participant.laps) !== 0"
          class="flex justify-between border-b-2 border-grey-darkest"
        >
          <div>{{ lang.total_pledged_amount }}</div>
          <div>${{ currency(pledgingTotal(participant.participant_info.pledges, participant.laps)) }}</div>
        </div>

        <div class="flex justify-between border-b-2">
          <div>{{ lang.payment_scheduled_online }}</div>
          <div>${{ currency(paymentScheduledOnline(participant)) }}</div>
        </div>
        <div class="flex justify-between border-b-2">
          <div>{{ lang.paid_online }}</div>
          <div>${{ currency(paidOnline(participant)) }}</div>
        </div>
        <div class="flex justify-between border-b-2">
          <div>{{ lang.checks_and_cash_deposits }}</div>
          <div>${{ currency(getCashAndChecks(participant.id)) || 0 }}</div>
        </div>
        <div class="flex justify-between border-b-2 border-grey-darkest">
          <div>{{ lang.total_payments_received }}</div>
          <div>${{ currency(totalPayments(participant)) }}</div>
        </div>

        <div class="text-base flex justify-between items-baseline">
          <div>{{ lang.outstanding }}</div>
          <div class="font-bold">
            ${{ currency(totalOutstanding(participant)) }}
          </div>
        </div>
      </div>
    </div>
    <div class="text-center mx-2 mt-4">
      <button
        class="inline-block py-2 px-4 text-secondary font-bold"
        @click="isOpen = !isOpen"
      >
        {{ isOpen ? lang.close_pledging_details : lang.view_pledging_details }}
      </button>
    </div>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import currency from '@/filters/currency'
import AvatarImage from '@/components/element/AvatarImage'

export default {
  name: 'PledgingDetailsSummaryCard',
  components: {
    AvatarImage,
  },
  props: {
    participants: {
      type: Array,
      default: () => [],
    },
    unit: {
      type: Object,
      default: null,
    },
    noUnitsEnteredDefault: {
      type: Number,
      default: 0,
    },
    ppuDonationsOnly: {
      type: Boolean,
      default: false,
    },
  },
  data: () => ({
    isOpen: false,
    cashAndChecks: [],
  }),
  computed: {
    ...mapState(['lang']),
    allPledgingTotal () {
      return this.participants.reduce((total, participant) => {
        return total + this.pledgingTotal(participant.participant_info.pledges, participant.laps)
      }, 0)
    },
    allPaymentsTotal () {
      return this.participants.reduce((total, participant) => {
        return total + this.paidOnline(participant) +
                    this.paymentScheduledOnline(participant) +
                    this.getCashAndChecks(participant.id)
      }, 0)
    },
    allOutstandingTotal () {
      const pledgingTotal = this.allPledgingTotal - this.allPaymentsTotal
      if (pledgingTotal <= 0) {
        return 0
      }

      return pledgingTotal
    },
  },
  methods: {
    currency,
    avatarSrc (participant) {
      return participant.profile.image_name == null ? '/v3-assets/dashboard/images/dashboard-avatar.svg' : this.avatarImgSrc(participant)
    },
    avatarImgSrc (participant) {
      return this.$store.getters.avatarPath + participant.profile.image_name
    },
    flatDonations (pledges) {
      const FLAT_TYPE = 3
      const total = pledges.reduce((total, pledge) => {
        if (pledge.pledge_type_id === FLAT_TYPE) {
          return total + pledge.amount
        }
        return total
      }, 0)
      return total
    },
    ppuDonations (pledges, laps) {
      const PPU_TYPE = 1
      const lapsToCharge = laps > 0 ? laps : this.noUnitsEnteredDefault
      const total = pledges.reduce((total, pledge) => {
        if (pledge.pledge_type_id === PPU_TYPE) {
          return total + pledge.amount * lapsToCharge
        }
        return total
      }, 0)
      return total
    },
    pledgingTotal (pledges, laps) {
      return this.flatDonations(pledges) + this.ppuDonations(pledges, laps)
    },
    paidOnline (participant) {
      const PAID_STATUS_ID = 3
      const paidPledges = participant.participant_info.pledges.filter(pledge => pledge.pledge_status_id === PAID_STATUS_ID)
      return this.flatDonations(paidPledges) + this.ppuDonations(paidPledges, participant.laps)
    },
    paymentScheduledOnline (participant) {
      const PAYMENT_SCHEDULED_STATUS_ID = 8
      const scheduledPledges = participant.participant_info.pledges.filter(pledge => pledge.pledge_status_id === PAYMENT_SCHEDULED_STATUS_ID)
      return this.flatDonations(scheduledPledges) + this.ppuDonations(scheduledPledges, participant.laps)
    },
    getCashAndChecks (participantId) {
      if (this.cashAndChecks[participantId] !== undefined &&
                !isNaN(this.cashAndChecks[participantId])) {
        return this.cashAndChecks[participantId]
      }
      this.participants.forEach(participant => {
        this.$axon
          .get('participant/manualPaymentTotal/' + participant.id)
          .then((response) => {
            this.$set(this.cashAndChecks, participant.id, response.data.total)
          })
      })
    },
    totalPayments (participant) {
      let totals = this.paidOnline(participant) + this.paymentScheduledOnline(participant)
      totals += this.cashAndChecks[participant.id] ? this.cashAndChecks[participant.id] : 0
      return totals
    },
    totalOutstanding (participant) {
      const totalOutstanding = this.pledgingTotal(participant.participant_info.pledges, participant.laps) - this.totalPayments(participant)
      if (totalOutstanding <= 0) {
        return 0
      }
      return totalOutstanding
    },
  },
}
</script>
