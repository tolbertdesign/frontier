<template>
  <div class="px-4 pt-6">
    <h2 class="mb-2 text-2xl font-semibold capitalize">
      {{ classroomName }} - {{ gradeName }} {{ lang.team_pom }}
    </h2>
    <p class="mb-4">
      {{ lang.team_progress }}
    </p>

    <div class="mb-4">
      <ProgressMeter
        :first-meter="pledgedTotal"
        :goal="pledgeGoal"
      />
      <div class="mt-2">
        <h3 class="font-bold">
          {{ lang.total_pledged }}: ${{ pledgedTotal | currency(true) }} of ${{ pledgeGoal | currency(true) }}
        </h3>
        <h4
          v-if="program.program_pledge_setting.flat_donate_only != true"
          class="capitalize"
        >
          {{ program.unit.modifier }} {{ program.unit.name }}
        </h4>
      </div>

      <div class="flex items-center justify-center mt-4">
        <button
          class="w-64 px-12 py-3 text-white rounded-full bg-secondary focus:outline-none focus:shadow-outline"
          @click="getReport"
        >
          {{ lang.pledge_report }}
        </button>
      </div>

    </div>
  </div>
</template>

<script>

export default {
  name: 'TeacherPledgeMeter',
  status: 'prototype',
  release: '1.0',
  props: {
    program: {
      type: Object,
      default: null,
    },
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    classroomName () {
      return this.$store.state.User.class_last_name
    },
    participant () {
      const teacherParticipantId = this.$store.state.User.teacher_participant_id
      return this.program.participants.find(participant => participant.id === teacherParticipantId)
    },
    gradeName () {
      return this.participant.participant_info.classroom.grade.display_name
    },
    pledgedTotal () {
      return this.$store.state.User.class_pledge_total
    },
    pledgeGoal () {
      return this.participant.participant_info.classroom.pledge_meter
    },
  },
  methods: {
    getReport () {
      this.$axon.get('report/class-pledge', () => {})
        .then((response) => {
          window.open(response.data.url, '_blank')
        })
    },
  },
}
</script>
