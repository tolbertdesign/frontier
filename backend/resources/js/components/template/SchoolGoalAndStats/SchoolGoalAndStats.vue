<template>
  <div class="school-goals-and-stats">
    <div
      v-if="isProgressPercentageSet"
      class="md:flex md:flex-row-reverse mb-4 md:border-b-2"
    >
      <div class="md:w-1/2 mb-4 text-center">
        <Carousel
          v-if="this.$parent.isOpen && program.microsite.images.length"
          :autoplay="true"
          :loop="true"
          :autoplay-timeout="3000"
          :speed="500"
          :per-page="1"
          :center-mode="true"
          :pagination-active-color="paginationActiveColor"
          :pagination-color="paginationNonActiveColor"
          :pagination-padding="6"
          class="p-4 mb-8 w-full lg:order-last relative elevation-1 rounded"
        >
          <Slide
            v-for="(image, index) in program.microsite.images"
            :key="index"
            :data-index="index"
            data-name="MySlideName"
          >
            <figure class="w-full relative aspect-ratio-16/9">
              <img
                :src="image"
                class="object-contain absolute pin w-full h-full"
              >
            </figure>
          </Slide>
        </Carousel>
      </div>
      <div
        class="md:w-1/2 flex items-center justify-between md:mb-4 md:pr-6"
      >
        <div :class="['w-2/3 px-4 md:p-4', hasGoalBeenMet ? 'mx-auto' : '']">
          <h2
            v-if="!hasGoalBeenMet"
            class="is-paddingless is-marginless text-xl"
          >
            {{ lang.total_goal_amt }}
          </h2>
          <h3
            v-if="!hasGoalBeenMet"
            class="is-paddingless is-marginless text-3xl font-semibold"
          >
            ${{ program.client_goal | currency(true) }}
          </h3>
          <p
            v-if="program.microsite.funds_raised_for"
            :class="['mb-6 hidden md:block ', hasGoalBeenMet ? 'text-2xl text-center' : 'text-lg' ]"
          >
            {{ lang.funds_raised_for }} {{ program.microsite.funds_raised_for.replace(/[.!]$/g, '!') }}
          </p>
        </div>
        <div class="md:p-4">
          <RingChart
            v-if="!hasGoalBeenMet"
            :value="progressPercentage"
            class="md:w-64 md:h-64 w-32 h-32"
          />
        </div>
      </div>
      <div :class="['text-xl mb-6 px-4 block md:hidden', hasGoalBeenMet ? 'mt-3 text-center' : '']">
        {{ lang.funds_raised_for }} {{ program.microsite.funds_raised_for.replace(/[.!]$/g, '!') }}
      </div>
    </div>
    <div class="md:flex pb-4">
      <div class="md:w-1/2 md:p-4 md:border-r-2">
        <header class="px-4">
          <h2 class="text-xl font-bold">
            {{ lang.pledge_o_meter }}
          </h2>
          <p class="text-sm mb-0">
            {{ lang.currency_symbol }}{{ program.unit_flat_conversion }}
            {{ lang.flat_conversion }}
            {{ lang.currency_symbol }}1
            {{ lang.per }}
            {{ program.unit.name }}
          </p>
          <p
            v-if="program.program_pledge_setting.flat_donate_only === 1"
            class="text-sm mb-4"
          >

            {{ lang.all_team_values_flat }}
          </p>
          <p
            v-if="program.program_pledge_setting.flat_donate_only !== 1"
            class="text-sm mb-4"
          >
            {{ lang.all_team_values_not_flat }} {{ program.unit.name }}
          </p>
        </header>
        <div class="mb-16 md:mb-0 p-0">
          <div class="mb-4 px-4">
            <Carousel
              v-if="this.$parent.isOpen && classroomChunks.length > 0"
              :navigation-enabled="true"
              :speed="500"
              :per-page="1"
              :center-mode="true"
              :pagination-padding="6"
              navigation-prev-label="<i class='fas fa-chevron-left'></i>"
              navigation-next-label="<i class='fas fa-chevron-right'></i>"
              class="md:p-4 mt-2 mb-8 mx-auto content-center lg:order-last relative pledge-o-meter-carousel w-full "
            >
              <Slide
                v-for="(classroomChunk, key) in classroomChunks"
                :key="key"
                :data-index="key"
                data-name="Pledge-O-Meter"
              >
                <div
                  v-for="(classroom, index) in classroomChunk"
                  :key="index"
                  :data-index="index"
                  :class="[
                    'team-meter pb-6',
                    {
                      'participant-class': classroom.isParticipantClassroom
                    }
                  ]"
                >
                  <p class="is-marginless">
                    {{ classroom.name }} {{ getGradeText(classroom) }}
                  </p>
                  <ProgressMeter
                    :goal="classroomGoal"
                    :first-meter="parseInt(Math.ceil(classroom.pledgeTotal))"
                    :color="classroom.color"
                    :show-value="true"
                    :value-to-display="getPledgeTotalForDisplay(classroom)"
                    background-color-class="bg-white"
                  />
                </div>
              </Slide>
            </Carousel>
          </div>
        </div>
      </div>
      <div class="md:w-1/2 p-4">
        <h2 class="text-xl font-bold">
          Pledges by State
        </h2>
        <PledgesByState :program="program" />
      </div>
    </div>
  </div>
</template>

<script>
import PledgesByState from '@/components/template/PledgesByState'
import Vue from 'vue'
import { Carousel, Slide } from 'vue-carousel'
import ProgressMeter from '@/components/element/ProgressMeter'
import RingChart from '@/components/element/RingChart'
import tailwindConfig from '@/../../tailwind.config.js'
import axios from 'axios'
import { mapState } from 'vuex'
import _ from 'lodash'

export default {
  name: 'SchoolGoalAndStats',
  status: 'prototype',
  release: '1.0.0',
  components: {
    Carousel, Slide, ProgressMeter, RingChart, PledgesByState,
  },
  props: {
    program: {
      type: Object,
      default: null,
    },
  },
  data () {
    return {
      progressPercentage: 100,
      paginationNonActiveColor: tailwindConfig.colors['grey-light'],
      paginationActiveColor: tailwindConfig.colors['grey-darkest'],
      isProgressPercentageSet: false,
      classroomChunks: [],
      classroomsPerSlide: 5,
      classroomGoal: 0,
    }
  },
  computed: {
    ...mapState(['lang']),
    hasGoalBeenMet () {
      return this.progressPercentage >= 100
    },
  },
  created () {
    if (this.program.total_raised_goal !== 0) {
      this.updateProgressPercentage()
    } else {
      this.isProgressPercentageSet = true
    }
    axios.get('/v3/api/programs/classroom-pledge-totals/' + this.program.id)
      .then(response => {
        if (response.data.length && typeof (response.data[0].pledgeTotal) === 'string') {
          this.classroomGoal = response.data[0].pledgeTotal
        }

        if (Array.isArray(response.data)) {
          this.classroomChunks = this.getClassroomChunks(this.program.participants, response.data)
        }
      })
  },
  methods: {
    getClassroomChunks (participants, classrooms) {
      const userClassrooms = []
      const nonUserClassrooms = []
      const alreadyUsedClassroomIds = []
      const userClassroomIds = []

      // Assign user classrooms
      participants.forEach(participant => {
        classrooms.forEach(classroom => {
          if (alreadyUsedClassroomIds.indexOf(classroom.id) === -1 && participant.participant_info.classroom_id === classroom.id) {
            classroom.color = 'secondary'
            classroom.isParticipantClassroom = true

            userClassroomIds.push(classroom.id)
            userClassrooms.push(classroom)
            alreadyUsedClassroomIds.push(classroom.id)
          }
        })
      })

      // Sort user classrooms
      userClassrooms.sort(this.sortByTotalAndName)

      // Assign non-user classrooms
      classrooms.forEach(classroom => {
        if (userClassroomIds.indexOf(classroom.id) !== -1) {
          classroom = Object.assign({}, classroom)
        }
        classroom.color = 'primary'
        classroom.isParticipantClassroom = false

        nonUserClassrooms.push(classroom)
      })

      // Sort non user classrooms
      nonUserClassrooms.sort(this.sortByTotalAndName)

      return _.chunk(userClassrooms.concat(nonUserClassrooms), this.classroomsPerSlide)
    },
    sortByTotalAndName (classroomA, classroomB) {
      const classroomATotal = classroomA.pledgeTotal ? parseFloat(classroomA.pledgeTotal) : 0
      const classroomBTotal = classroomB.pledgeTotal ? parseFloat(classroomB.pledgeTotal) : 0

      if (classroomATotal < classroomBTotal) {
        return 1
      } else if (classroomATotal === classroomBTotal) {
        const classAName = classroomA.name.toLowerCase().replace('ms.', 'mr.', 'mrs.') + classroomA.gradeText
        const classBName = classroomB.name.toLowerCase().replace('ms.', 'mr.', 'mrs.') + classroomB.gradeText
        return (classAName > classBName) ? 1 : -1
      } else {
        return -1
      }
    },
    getGradeText (classroom) {
      return (classroom.gradeText === '' ? '' : ' - ' + classroom.gradeText)
    },
    getPledgeTotalForDisplay (classroom) {
      if (classroom.pledgeTotal) {
        return Vue.filter('Currency')(Math.ceil(classroom.pledgeTotal), true, this.lang.currency_symbol)
      }

      return this.lang.currency_symbol + '0'
    },
    toPercentageValue (numerator, denominator = this.program.total_raised_goal) {
      return parseInt(numerator / denominator * 100)
    },
    updateProgressPercentage () {
      axios.get('/v3/api/programs-total-pledged/' + this.program.id)
        .then(response => {
          this.progressPercentage = this.toPercentageValue(response.data)
          this.isProgressPercentageSet = true
        })
    },
  },
}
</script>

<style lang="scss">
.pledge-o-meter-carousel .VueCarousel-dot, .pledge-o-meter-carousel .VueCarousel-dot-container {
    margin-top: 0px !important;
}
@media (max-width: 640px) {
    .pledge-o-meter-carousel .VueCarousel-navigation {
        display: none;
    }
}
.VueCarousel-pagination {
    position: absolute;
    bottom: -2rem;
    margin-left: -1rem;
}
.aspect-ratio-16\/9 { padding-top: 56.25% }

.team-meter.participant-class {
    @apply relative mb-8 pb-10;
}
.team-meter.participant-class:after {
    @apply absolute w-full mx-auto h-px bg-grey-dark;
    content: '';
    bottom: -4px;
    left: 0;
    right: 0;
    transition:.5s;
}
</style>
