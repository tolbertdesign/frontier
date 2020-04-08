<template>
  <section class="participant-rewards">
    <Transition name="fade">
      <article
        v-if="show"
        class="py-8"
      >
        <a
          class="text-2xl text-black float-right"
          @click="toggleRewards(participant.id)"
        >
          <i class="fal fa-times" />
        </a>
        <h1 class="text-2xl font-bold">
          {{ lang.rewards }}
        </h1>
        <h2
          v-if="program.program_pledge_setting.flat_donate_only === '0'"
          class="mb-4"
        >
          ${{ program.unit_flat_conversion }} {{ lang.flat_donation }} = $1 {{ program.unit.modifier }} {{ program.unit.name }}
        </h2>

        <TeacherIncentives v-if="shouldDisplayIncentives" />

        <!-- Shown when greater than small, hidden when small -->
        <div class="hidden sm:block mb-4">
          <ParticipantRewardsCard
            v-for="reward in rewards"
            :key="reward.id"
            :reward="reward"
            :program="program"
            :sum-pledges-flat="sumPledgesFlat"
          />
        </div>

        <!-- Shown when small, hidden when greater than small -->
        <div class="sm:hidden mb-4">
          <ParticipantRewardsCard
            v-for="reward in topRewards"
            :key="reward.id"
            :reward="reward"
            :program="program"
            :sum-pledges-flat="sumPledgesFlat"
          />

          <ParticipantRewardsCard
            v-for="reward in remainingRewards"
            :key="reward.id"
            :reward="reward"
            :program="program"
            :sum-pledges-flat="sumPledgesFlat"
            :class="[viewMore ? '' : 'hidden']"
          />
        </div>

        <div class="sm:hidden mb-6 pb-4 text-center border-grey">
          <a
            class="text-blue hover:text-blue-dark"
            @click="toggleViewMore"
          >
            {{ lang.view }} {{ viewMore ? lang.less : lang.more }}
          </a>
        </div>

        <div class="flex items-center justify-center border-b lg:border-none pb-6">
          <button
            class="py-2 px-8 rounded-full font-semibold text-sm text-white bg-secondary shadow focus:outline-none focus:shadow-outline"
            @click="toggleRewards(participant.id)"
          >
            <span>{{ lang.close }} {{ lang.rewards }}</span>
          </button>
        </div>
      </article>
    </Transition>
  </section>
</template>

<script>
import ParticipantRewardsCard from '@/components/template/ParticipantRewardsCard'
import TeacherIncentives from '@/components/template/TeacherIncentives'
import PledgeTotalCalculator from '@/utilities/PledgeTotalCalculator.js'
import { STATUS_CONFIRMED, STATUS_PAID, STATUS_PAYMENT_SCHEDULED, STATUS_PENDING } from '@/store/modules/pledge.js'

export default {
  name: 'ParticipantRewards',
  status: 'prototype',
  release: '1.0.0',
  components: {
    ParticipantRewardsCard,
    TeacherIncentives,
  },
  props: {
    program: {
      type: Object,
      default: null,
    },
    participant: {
      type: Object,
      default: null,
    },
    show: {
      type: Boolean,
      default: false,
    },
  },
  data () {
    return {
      viewMore: false,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    shouldDisplayIncentives () {
      if (this.$store.state.User.is_teacher_user && !this.program.hide_teacher_incentives) {
        return this.isTeacherInProgram
      }
      return false
    },
    isTeacherInProgram () {
      if (this.program.participants.find(participant => participant.id === this.$store.state.User.teacher_participant_id)) {
        return true
      }

      return false
    },
    rewards () {
      let combinedPrizeObjects = this.getCombinedPrizeObjects()
      combinedPrizeObjects = this.filterPrizesForDisplay(combinedPrizeObjects)
      combinedPrizeObjects = this.sortPrizesForDisplay(combinedPrizeObjects)
      return combinedPrizeObjects
    },
    topRewards () {
      return this.rewards.slice(0, 4)
    },
    remainingRewards () {
      return this.rewards.slice(4)
    },
    sumPledgesFlat () {
      const calculator = new PledgeTotalCalculator(this.program, this.participant.participant_info.pledges, [
        STATUS_CONFIRMED,
        STATUS_PAID,
        STATUS_PAYMENT_SCHEDULED,
        STATUS_PENDING,
      ])
      return calculator.getTotalAsFlat()
    },
  },
  methods: {
    sortPrizesForDisplay (combinedPrizeObjects) {
      return combinedPrizeObjects.sort((a, b) => {
        return a.prizeBound.display_amount - b.prizeBound.display_amount
      })
    },
    filterPrizesForDisplay (combinedPrizeObjects) {
      return combinedPrizeObjects.filter(prizeBoundStudent => {
        const isNotActivityReward = prizeBoundStudent.prizeBound.activity_reward === null
        const hasNoPeriod = prizeBoundStudent.prizeBound.starts_at === null &&
                    prizeBoundStudent.prizeBound.ends_at === null
        const isNotQuantity = prizeBoundStudent.prizeBound.quantity === null
        let isInPeriod = false
        let isDisplayableStatus = true
        const displayableStatuses = [
          'giveaway',
          'delivered',
          'pending',
        ]
        if (!hasNoPeriod) {
          isInPeriod = new Date(prizeBoundStudent.prizeBound.starts_at) < new Date() &&
                        new Date(prizeBoundStudent.prizeBound.ends_at) > new Date()
          isDisplayableStatus = displayableStatuses.includes(prizeBoundStudent.status)
        }

        return (isNotActivityReward && (hasNoPeriod || isInPeriod || isDisplayableStatus) && isNotQuantity)
      })
    },
    getCombinedPrizeObjects () {
      const prizeBoundStudents = this.participant.participant_info.prize_bound_students
      const prizesBound = this.participant.participant_info.classroom.group.prizes_bound.reduce((prizesBound, prizeBound) => {
        prizesBound[prizeBound.prize_id] = prizeBound
        return prizesBound
      }, {})
      const prizes = this.participant.prizes.reduce((prizes, prize) => {
        prizes[prize.id] = prize
        return prizes
      }, {})
      return prizeBoundStudents.map(prizeBoundStudent => {
        prizeBoundStudent.prizeBound = prizesBound[prizeBoundStudent.prize_id]
        prizeBoundStudent.prize = prizes[prizeBoundStudent.prize_id]
        return prizeBoundStudent
      })
    },
    toggleRewards (id) {
      this.$parent.toggleParticipant(id)
    },
    toggleViewMore () {
      if (this.viewMore) {
        this.viewMore = false
        this.scrollTo()
      } else {
        this.viewMore = true
      }
    },
    scrollTo () {
      setTimeout(() => {
        $('html, body').animate({
          scrollTop: 0,
        }, 300)
      }, 310)
    },
  },
}
</script>
