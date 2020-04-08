<template>
  <div class="px-4 pt-6">
    <h2 class="text-2xl font-semibold capitalize">
      {{ lang.teacher_action_steps }}
    </h2>
    <BTabs>
      <BTabItem
        ref="incomplete_tab"
      >
        <template slot="header">
          <span>
            <span class="text-xl font-medium">{{ lang.incomplete }}</span>
            <BTag
              size="is-medium"
              type="is-light"
              rounded
            >
              {{ incompleteTasks.length }}
            </BTag>
          </span>
        </template>
        <ul
          v-if="incompleteTasks.length"
          class="mt-1 overflow-y-auto h-60 list-reset"
        >
          <li
            v-for="task in incompleteTasks"
            :key="task.id"
            class="flex p-2 m-1 border rounded-lg"
          >
            <label class="flex items-center w-full cursor-pointer">
              <input
                type="checkbox"
                class="w-6 h-6 form-checkbox"
                @change="toggle(task.id)"
              >
              <span class="ml-3">{{ task.title }}</span>
            </label>
          </li>
        </ul>
        <div
          v-else
          class="mt-2 mx-1 border rounded-lg h-60 flex items-center justify-center"
        >
          {{ lang.all_tasks_complete }}
        </div>
      </BTabItem>

      <BTabItem>
        <template slot="header">
          <span>
            <span class="text-xl font-medium">{{ lang.completed }}</span>
            <BTag
              size="is-medium"
              type="is-light"
              rounded
            >
              {{ completedTasks.length }}
            </BTag>
          </span>
        </template>
        <!-- Completed list -->
        <ul
          v-if="completedTasks.length > 0"
          class="mt-1 overflow-y-auto h-60 list-reset"
        >
          <li
            v-for="task in completedTasks"
            :key="task.id"
            class="flex p-2 m-1 border rounded"
          >
            <label class="flex items-center w-full cursor-pointer">
              <input
                type="checkbox"
                class="w-6 h-6 form-checkbox"
                @change="toggle(task.id)"
              >
              <span class="ml-3">{{ task.title }}</span>
            </label>
          </li>
        </ul>
        <div
          v-else
          class="mt-2 mx-1 border rounded-lg h-60 flex items-center justify-center"
        >
          {{ lang.all_tasks_incomplete }}

        </div>
      </BTabItem>
    </BTabs>
    <p class="mb-6">
      {{ lang.view_templates }}:
      <button
        class="font-medium underline text-secondary"
        @click="showEmailTemplatesModal('english')"
      >{{ lang.english }}</button>
      <span> | </span>
      <button
        class="font-medium underline text-secondary"
        @click="showEmailTemplatesModal('spanish')"
      >{{ lang.spanish }}</button>
    </p>
  </div>
</template>

<script>
import Blur from '@/mixins/Blur'
import TeacherIncentives from '@/components/template/TeacherIncentives'
import TeacherEmailTemplates from '@/components/template/TeacherEmailTemplates'

export default {
  name: 'TeacherActionSteps',
  status: 'prototype',
  release: '1.0',
  components: {
    TeacherIncentives,
    TeacherEmailTemplates,
  },
  mixins: [Blur],
  props: {
    tasks: {
      type: Array,
      default: null,
    },
    program: {
      type: Object,
      default: () => {},
    },
  },
  data () {
    return {
      teacherTasks: [],
    }
  },
  computed: {
    incompleteTasks () {
      return this.teacherTasks
        .filter(task => task.completed_on_date === null)
    },
    completedTasks () {
      return this.teacherTasks
        .filter(task => task.completed_on_date != null)
    },
    lang () {
      return this.$store.state.lang
    },
    classroomName () {
      return this.$store.state.User.class_last_name || this.participant.participant_info.classroom.name
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
  mounted () {
    this.teacherTasks = this.tasks
    // // The below is a hack to get around an issue in safari
    // // where the initial tab's display isn't drawn
    this.$refs.incomplete_tab.$el.style.display = 'block'
  },
  methods: {
    toggle (id) {
      const teacherTask = this.teacherTasks.find(task => task.id === id)

      const taskForUpdate = { ...teacherTask }
      if (!taskForUpdate.completed_on_date) {
        taskForUpdate.completed_on_date = new Date()
      } else {
        taskForUpdate.completed_on_date = null
      }

      this.$axon.update('user-task', teacherTask.id, taskForUpdate, () => {}).then((response) => {
        teacherTask.completed_on_date = response.data.userTask.completed_on_date
        teacherTask.completed_by_user_id = response.data.userTask.completed_by_user_id
      })
    },
    showEmailTemplatesModal (language) {
      this.$buefy.modal.open({
        parent: this,
        component: TeacherEmailTemplates,
        canCancel: ['escape', 'outside'],
        hasModalCard: true,
        width: 'auto',
        onCancel: this.unBlur,
        scroll: 'clip',
        props: {
          language: language,
          program: this.program,
        },
      })
      this.blur()
    },
  },
}
</script>
