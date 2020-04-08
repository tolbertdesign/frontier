<template>
  <div>
    <Accordion
      v-for="(item, index) in items"
      :key="index"
      :is-open="item.isOpen"
      :title="item.title"
      :should-reslick="true"
    >
      <template>
        <Component
          :is="item.name"
          :program="program"
        />
      </template>
    </Accordion>
  </div>
</template>

<script>
import Accordion from '@/components/element/Accordion'
import ProgramOverview from '@/components/template/ProgramOverview'
import SchoolGoalAndStats from '@/components/template/SchoolGoalAndStats'
import HowToGetPledges from '@/components/template/HowToGetPledges'
import StudentStarVideo from '@/components/template/StudentStarVideo'
import PledgeInfo from '@/components/template/PledgeInfo'
import BusinessLeaderboard from '@/components/template/BusinessLeaderboard'

export default {
  name: 'TeacherDashboardAccordion',
  status: 'prototype',
  version: '1.0.0',
  components: {
    Accordion,
    ProgramOverview,
    SchoolGoalAndStats,
    HowToGetPledges,
    StudentStarVideo,
    PledgeInfo,
    BusinessLeaderboard,
  },
  props: {
    program: {
      type: Object,
      default: null,
    },
  },
  data () {
    let items = [
      {
        name: 'ProgramOverview',
        title: 'Program Overview',
        isOpen: false,
      },
      {
        name: 'SchoolGoalAndStats',
        title: 'School Goal and Stats',
        isOpen: false,
      },
      {
        name: 'StudentStarVideo',
        title: this.studentStarVideoTitle(),
        isOpen: false,
      },
      {
        name: 'HowToGetPledges',
        title: 'How To Get Pledges',
        isOpen: false,
      },
      {
        name: 'PledgeInfo',
        title: this.pledgeInfoTitle(),
        isOpen: false,
      },
      {
        name: 'BusinessLeaderboard',
        title: 'Business Leaderboard',
        isOpen: true,
      },
    ]
    if (this.program.ssv_disabled) {
      items = items.filter(item => item.name !== 'StudentStarVideo')
    }
    return {
      items: items,
      selected: null,
    }
  },
  methods: {
    pledgeInfoTitle () {
      let title = 'Pledges'
      if (this.pledgesCount()) {
        title += ' (' + this.pledgesCount() + ')'
      }
      return title
    },
    pledgesCount () {
      return new Set(this.program.participants
        .map(participant => participant.participant_info.pledges.map(pledge => pledge.family_pledge_id || pledge.id))
        .flat(1)).size
    },
    studentStarVideoTitle () {
      return this.program.participants
        .find(participant => participant.profile.image_name !== null)
        ? 'Share Student Star Video'
        : 'Create Student Star Video'
    },
  },
}
</script>
