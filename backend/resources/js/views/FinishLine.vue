<template>
  <div>
    <section
      :class="program.microsite.microsite_color_theme.theme_name"
      class="page min-h-screen pb-16"
    >
      <AppHeader :program="program">
        <div class="flex flex-col">
          <PageHeader>
            {{ lang.finish_line }}
          </PageHeader>
          <p class="sub-header text-white text-2xl">
            {{ program.event_name }}
          </p>
          <EventInfo
            :funrun-date="new Date(program.fun_run)"
            :display-days-remaining="false"
            class="hidden lg:flex"
          />
        </div>
      </AppHeader>
      <div>
        <main class="mx-2">
          <h1 class="text-28 fw-200 d-block mb-4 -mt-8 text-center text-black font-bold">
            {{ lang.finish_line }}
          </h1>
          <div class="has-text-centered mb-4">
            <Trophy class="max-w-xs w-20" />
          </div>
          <div class="lg:flex flex-wrap justify-center">
            <div class="lg:w-1/2">
              <FinishLineParticipantCard
                v-for="(participant, index) in program.participants"
                :key="index"
                :participant="participant"
                :unit="program.unit"
                :unit-max="program.unit_range_high"
                :can-edit="canEditUnits(program.fun_run)"
              />
            </div>
          </div>
          <div class="px-8 pt-8 pb-2 mx-auto my-2 lg:w-1/2 max-w-lg border border-grey-light rounded-lg shadow">
            <PledgingDetailsSummaryCard
              :participants="program.participants"
              :unit="program.unit"
              :no-units-entered-default="program.no_units_entered_default"
              :ppu-donations-only="program.program_pledge_setting.ppu_donations_only"
            />
          </div>
          <div class="text-center mx-auto w-72 text-xs py-8 px-4">
            <p>
              {{ lang.can_also_pay_string }}
              <b>{{ getFormattedDueDate(program.due_date) }}</b>.
              <span v-if="program.payee">
                {{ lang.payee_string }}
                <b>{{ program.payee }}</b>.
              </span>
            </p>
          </div>
          <div>
            <PledgeButton
              :participants="program.participants"
              class="mb-4"
            />
            <RoundedButton
              :text="lang.pay_pledges"
              :disabled="allPledgesPaid(program)"
              link="#"
              class="is-secondary my-2"
              @click.native="payPledges"
            />
          </div>
        </main>
      </div>
    </section>
  </div>
</template>

<script>
import AppHeader from '@/components/template/AppHeader'
import EventInfo from '@/components/pattern/EventInfo'
import PageHeader from '@/components/pattern/PageHeader'
import PledgeButton from '@/components/element/PledgeButton'
import FinishLineParticipantCard from '@/components/template/FinishLineParticipantCard'
import PledgingDetailsSummaryCard from '@/components/template/PledgingDetailsSummaryCard'
import { STATUS_PAID, STATUS_CANCELLED, STATUS_DELETED, STATUS_ABANDONED } from '@/store/modules/pledge.js'

export default {
  name: 'FinishLine',
  status: 'prototype',
  release: '1.0.0',
  components: {
    AppHeader,
    EventInfo,
    PageHeader,
    PledgeButton,
    FinishLineParticipantCard,
    PledgingDetailsSummaryCard,
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    program () {
      let participantProgram = {}
      this.$store.state.User.programs.forEach(program => {
        program.participants.forEach(participant => {
          if (participant.id === this.id) {
            participantProgram = program
          }
        })
      })

      return participantProgram
    },
    id () {
      return parseInt(this.$route.params.participantUserId)
    },
  },
  methods: {
    getFormattedDueDate (date) {
      const dueDate = new Date(date)
      return (dueDate.getMonth() + 1) + '/' + dueDate.getDate() + '/' + dueDate.getFullYear()
    },
    allPledgesPaid (program) {
      const invalidPledgeStatuses = [
        STATUS_CANCELLED,
        STATUS_DELETED,
        STATUS_ABANDONED,
      ]
      let hasUnpaidPledge = false

      program.participants.forEach(participant => {
        participant.participant_info.pledges.forEach(pledge => {
          if (pledge.pledge_status_id !== STATUS_PAID && !invalidPledgeStatuses.includes(pledge.pledge_status_id)) {
            hasUnpaidPledge = true
          }
        })
      })

      return !hasUnpaidPledge
    },
    payPledges (e) {
      if (this.allPledgesPaid) {
        e.preventDefault()
      }
    },
    canEditUnits (date) {
      const today = new Date()
      const threeDaysFromFunrun = new Date(date)
      threeDaysFromFunrun.setDate(threeDaysFromFunrun.getDate() + 3)
      return threeDaysFromFunrun >= today
    },
  },
  metaInfo: {
    title: 'Finish Line',
  },
}
</script>
