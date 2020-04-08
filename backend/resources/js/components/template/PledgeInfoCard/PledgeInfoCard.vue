<template>
  <div :class="['pledge-info-card max-w-full flip-card', {flipped: flipped}]">
    <div class="flip-card-inner">
      <div
        class="flip-card-front h-full bg-white border border-b-2 shadow-md border-grey-light rounded-lg p-2 px-4"
      >
        <div class="flex items-center mb-2">
          <div class="w-1/2">
            <div class="leading-none">
              <span
                :title="pledgeSponsor.first_name + ' ' + pledgeSponsor.last_name"
                class="font-semibold text-lg truncate pr-4 sm:pr-0 inline-block w-full"
              >{{ pledgeSponsor.first_name }} {{ pledgeSponsor.last_name }}</span>
              <br>
              <span class="text-2xs has-text-grey">{{ date }}</span>
            </div>
          </div>
          <div class="w-1/2 has-text-right">
            <div class="flex justify-end">
              <a
                v-if="pledges[0].comment"
                class="ml-2 flex flex-col items-center has-text-grey"
                @click.prevent="viewComment"
              >
                <FontAwesomeIcon :icon="['far', 'comment-alt-lines']" />
                <div class="text-2xs whitespace-no-wrap capitalize">{{ lang.view_comment }}</div>
              </a>
              <a
                v-if="isMissingPayment"
                class="ml-2 flex flex-col items-center has-text-grey"
                @click.prevent="remind(pledges[0].id)"
              >
                <FontAwesomeIcon :icon="['far', 'envelope']" />
                <div class="text-2xs capitalize">{{ lang.remind }}</div>
              </a>
              <a
                class="ml-6 flex flex-col items-center has-text-grey"
                @click.prevent="edit"
              >
                <FontAwesomeIcon :icon="['far', 'edit']" />
                <div class="text-2xs capitalize">{{ lang.edit }}</div>
              </a>
            </div>
          </div>
        </div>
        <div>
          <div
            v-for="(pledge) in familyPledges"
            :key="pledge.id + update"
            class="text-sm"
          >
            <div class="flex justify-between border-b-2">
              <div>{{ pledge.participant.first_name }}</div>
              <div>
                ${{ pledge.amount }}
                <span
                  v-if="pledge.pledge_type_id === 1"
                >{{ program.unit.modifier }} {{ program.unit.name }}</span>
              </div>
            </div>
            <div
              v-if="showAllStatuses || isLastPledge(pledge)"
              class="flex justify-between items-baseline"
            >
              <span
                :class="[statusClasses[pledge.pledge_status_id]]"
                class="capitalize font-bold"
              >{{ lang.statuses[pledge.pledge_status_id] }}</span>
              <div
                v-if="isLastPledge(pledge)"
                class="text-base"
              >
                {{ lang.total }}
                <span class="font-bold">{{ pledgeTotal }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div
        class="flip-card-back flex flex-col align-middle bg-white border border-b-2 shadow-md border-grey-light rounded-lg p-2 px-4"
      >
        <div class="flex items-center mb-2">
          <div class="w-1/2">
            <div class="leading-none">
              <span
                class="font-semibold"
              >{{ pledgeSponsor.first_name }} {{ pledgeSponsor.last_name }}</span>
            </div>
          </div>
          <div class="w-1/2 has-text-right">
            <div class="flex justify-end">
              <a
                class="ml-6 flex flex-col items-center has-text-grey"
                @click.prevent="flip"
              >
                <FontAwesomeIcon :icon="['far', 'times']" />
              </a>
            </div>
          </div>
        </div>
        <p class="p-4 flex flex-1 items-center justify-center">
          <span class="text-center">“{{ pledges[0].comment }}”</span>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import currency from '@/filters/currency'
import PledgeReminderModal from '@/components/element/PledgeReminderModal'
import EditPledgeForm from '@/components/template/EditPledgeForm'
import Blur from '@/mixins/Blur'

export default {
  mixins: [Blur],
  props: {
    pledges: {
      type: Array,
      default: null,
    },
    program: {
      type: Object,
      default: null,
    },
  },
  data () {
    return {
      flipped: false,
      statusClasses: {
        1: 'text-green',
        2: '',
        3: 'text-green',
        4: 'text-orange',
        5: 'text-green',
        6: 'text-green',
        7: 'text-green',
        8: 'text-green',
      },
      update: 1,
      canDeletePledgeStatuses: [
        2, // Confirmed
        4, // Pending
      ],
      nonDeniedOnlinePendingPaymentsStatuses: [
        1, // Pending
        2, // Processing
        3, // Paid
      ],
      PAID_STATUS_ID: 3,
      CONFIRMED_STATUS_ID: 2,
      PENDING_STATUS_ID: 4,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    showAllStatuses () {
      const statuses = this.pledges.map(pledge => {
        return pledge.pledge_status_id
      })
      const statusSet = new Set(statuses)
      return statusSet.size > 1
    },
    pledgeSponsor () {
      return this.familyPledges[0].pledge_sponsor || {}
    },
    date () {
      const date = new Date(this.pledges[0].ts_entered)
      return this.lang.pledges.months[date.getMonth()] + ' ' + date.getDate()
    },
    pledgeTotal () {
      const totals = this.familyPledges.reduce(
        (totals, pledge) => {
          if (pledge.pledge_type_id === 1) {
            totals.low += parseFloat(pledge.amount) * this.program.unit_range_low
            totals.high += parseFloat(pledge.amount) * this.program.unit_range_high
          } else {
            totals.low += parseFloat(pledge.amount)
            totals.high += parseFloat(pledge.amount)
          }
          return totals
        },
        { low: 0, high: 0 },
      )
      let totalsString = currency(totals.low, true, '$')
      if (totals.low !== totals.high) {
        totalsString += ' to ' + currency(totals.high, true, '$')
      }
      return totalsString
    },
    isMissingPayment () {
      const unPaidPledge = this.pledges.find((pledge) => {
        return pledge.hasPendingPayment === false && pledge.payment_id === null
      })
      return unPaidPledge !== undefined
    },
    familyPledges () {
      return this.update > 0 ? this.$store.getters.familyPledges(this.pledges, this.program) : []
    },
  },
  methods: {
    remind (pledgeId) {
      this.blur()
      this.showReminderEmailModal(pledgeId)
      this.gaEvent('Parent Dashboard', 'Pledges', 'Remind')
    },
    hasLaps () {
      return this.pledges[0].laps !== null && this.pledges[0].laps !== ''
    },
    isConfirmedWithLaps () {
      return this.pledges[0].pledge_status_id === this.CONFIRMED_STATUS_ID && this.hasLaps()
    },
    isPaidStatus () {
      return this.pledges[0].pledge_status_id === this.PAID_STATUS_ID
    },
    isNotSponsor () {
      return this.pledges[0].user_id !== this.$store.state.User.id
    },
    isPendingWithoutPayment () {
      return this.pledges[0].pledge_status_id === this.PENDING_STATUS_ID && !this.pledges[0].hasPendingPayment
    },
    canDelete () {
      if (this.isPaidStatus()) {
        return false
      }

      if (this.isConfirmedWithLaps()) {
        return false
      }

      if (this.isPendingWithoutPayment() && this.isNotSponsor()) {
        return false
      }

      return true
    },
    edit (pledge) {
      this.gaEvent('Parent Dashboard', 'Pledges', 'Edit')
      this.$buefy.modal.open({
        parent: this,
        canCancel: ['escape', 'outside'],
        component: EditPledgeForm,
        hasModalCard: false,
        customClass: 'edit-pledge-modal',
        width: 375,
        onCancel: this.unBlur,
        props: {
          pledgeData: this.familyPledges,
          canDelete: this.canDelete(),
          program: this.program,
        },
        events: {
          close: evt => {
            this.unBlur()
          },
        },
      })
      this.blur()
      this.isEditing = false
    },
    unBlur () {
      this.update++
      this.$forceUpdate()
      document.getElementById('app').style.filter = 'none'
    },
    viewComment () {
      this.flip()
      this.gaEvent('Parent Dashboard', 'Pledges', 'View Comments')
    },
    flip () {
      this.flipped = !this.flipped
    },
    showReminderEmailModal (pledgeId) {
      document.querySelector('body').classList.add('modal-is-open')

      this.$buefy.modal.open({
        parent: this,
        component: PledgeReminderModal,
        props: {
          pledgeId: pledgeId,
        },
        hasModalCard: true,
        canCancel: ['escape', 'outside'],
        onCancel: () => {
          document.querySelector('body').classList.remove('modal-is-open')
          this.unBlur()
        },
      })
      this.blur()
    },
    isLastPledge (pledge) {
      return pledge === this.familyPledges.slice(-1)[0]
    },
  },
}
</script>

<style lang="scss">

.pledge-info-card {
    width: 24rem;
}

.flip-card {
    background-color: transparent;
    perspective: 1000px;

    .table th,
    .table td {
        padding: 0.25rem 0;
    }
}

.flip-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.8s;
    transform-style: preserve-3d;
}

.flip-card.flipped .flip-card-inner {
    transform: rotateY(180deg);
}

.flip-card-front {
    position: relative;
    backface-visibility: hidden;
}

.flip-card-back {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backface-visibility: hidden;
}

.flip-card-back {
    transform: rotateY(180deg);
}

.edit-pledge-modal .modal-content {
    @apply shadow-lg;
}
</style>
