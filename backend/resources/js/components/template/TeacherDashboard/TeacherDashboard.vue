<template>
  <div class="mx-4 lg:mx-0 mb-16 lg:mb-8">
    <div class="flex flex-col rounded-lg lg:flex-row lg:border lg:shadow">
      <div
        v-if="!program.hide_teacher_action_steps"
        class="w-full mb-6 border rounded-lg shadow lg:mb-0 lg:w-1/2 lg:rounded-none lg:shadow-none lg:border-t-0 lg:border-b-0 lg:border-l-0"
      >
        <TeacherActionSteps
          :program="program"
          :tasks="teacherParticipant.user_tasks"
        />
      </div>
      <div
        :class="{ 'lg:w-full': program.hide_teacher_action_steps }"
        class="w-full border rounded-lg shadow lg:w-1/2 lg:border-none lg:shadow-none"
      >
        <TeacherPledgeMeter :program="program" />
      </div>
    </div>
  </div>
</template>

<script>
import TeacherActionSteps from '@/components/template/TeacherActionSteps'
import TeacherPledgeMeter from '@/components/template/TeacherPledgeMeter'

export default {
  name: 'TeacherDashboardComponent',
  status: 'prototype',
  release: '1.0',
  components: {
    TeacherActionSteps,
    TeacherPledgeMeter,
  },
  props: {
    program: {
      type: Object,
      default: null,
    },
  },
  computed: {
    teacherParticipant () {
      return this.$store.getters.teacherParticipant(this.program)
    },
  },
}
</script>
