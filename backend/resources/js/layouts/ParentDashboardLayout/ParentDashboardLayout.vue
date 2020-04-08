<template>
  <div class="container max-w-xl">
    <BetaBanner v-if="!betaBannerKillSwitch" />

    <!-- Mobile (desktop hidden)-->
    <EventInfo
      :funrun-date="new Date(program.fun_run)"
      class="flex justify-between mb-4 px-6 lg:hidden"
    />

    <!-- Mobile (desktop hidden)-->
    <div class="lg:hidden mx-4 mb-8 border rounded-lg shadow-md">
      <div class="mobile-cards lg:flex flex-wrap">
        <div
          v-for="(participant, index) in participants"
          :key="index"
          class="lg:w-1/2"
        >
          <ParticipantCard
            :participant="participant"
            :program="program"
            :selected="selected"
            @toggle="toggleParticipant($event)"
          />
          <div class="px-4 lg:px-8">
            <ParticipantRewards
              :program="program"
              :participant="participant"
              :show="selected == participant.id"
            />
          </div>
        </div>
      </div>
    </div>

    <!-- Desktop (mobile hidden)-->
    <div class="hidden lg:block">
      <div
        v-for="(participantGroup, index) in participantGroups"
        :key="index"
        class="mb-8 rounded-lg border shadow-md overflow-hidden"
      >
        <ParticipantGroup
          :program="program"
          :participant-group="participantGroup"
          :has-only-one-participant="participants.length === 1"
        />
      </div>
    </div>

    <!-- Shown on both Mobile and Desktop -->
    <div class="max-w-sm mx-auto mb-8 px-8">
      <PledgeButton :participants="participants" />
    </div>

    <div class="mx-4 lg:mx-0 mb-8 p-8 border-t lg:border lg:rounded-lg lg:shadow-md">
      <div class="text-center max-w-sm lg:max-w-lg mx-auto">
        <h2 class="text-xl font-semibold">
          {{ lang.share_pledge_page }}
        </h2>
        <h3>{{ lang.every_share_can }}</h3>
        <ShareButtons
          :participants="participants"
          :program="program"
        />
      </div>
    </div>

    <ParentDashboardAccordion :program="program" />
  </div>
</template>

<script>
import BetaBanner from '@/components/pattern/BetaBanner'
import EventInfo from '@/components/pattern/EventInfo'
import ParentDashboardAccordion from '@/components/template/ParentDashboardAccordion'
import ParticipantCard from '@/components/template/ParticipantCard'
import ParticipantGroup from '@/components/template/ParticipantGroup'
import ParticipantRewards from '@/components/template/ParticipantRewards'
import PledgeButton from '@/components/element/PledgeButton'
import ShareButtons from '@/components/pattern/ShareButtons'
import { chunk } from 'lodash'

export default {
  name: 'ParentDashboardLayout',
  release: '1.0.0',
  components: {
    BetaBanner,
    EventInfo,
    ParentDashboardAccordion,
    ParticipantCard,
    ParticipantGroup,
    ParticipantRewards,
    PledgeButton,
    ShareButtons,
  },
  props: {
    program: {
      type: Object,
      default: undefined,
    },
  },
  data () {
    return {
      selected: null,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    betaBannerKillSwitch () {
      return this.$store.state.beta_banner_kill_switch
    },
    participants () {
      return this.program.participants
    },
    participantGroups () {
      return chunk(this.program.participants, 2)
    },
  },
  methods: {
    toggleParticipant (id) {
      if (this.selected !== id) {
        this.selected = id
      } else {
        this.selected = null
      }
    },
  },
}
</script>

<style>
    .mobile-cards > :last-child .button-container { border-bottom: none }

    .banner_dashboard {
        padding: 0 0 2rem 0;
        text-align: center;
        font-family: sans-serif;
        max-width: 80%;
    }
    .banner_dashboard a {
        display: inline-flex;
        align-items: center;
        border-radius: 9999px;
        padding: .5rem 1rem;
        line-height: 1;
        text-decoration: none;
    }
    .banner_dashboard .message {
        flex: 1 1 auto;
        text-left: left;
        font-weight: 600;
    }
</style>
