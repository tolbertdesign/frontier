<template>
  <ul class="page min-h-screen">
    <li
      v-for="(program, index) in teacherPrograms"
      :key="index"
    >
      <section
        :class="program.microsite.microsite_color_theme.theme_name"
        class="page min-h-screen"
      >
        <AppHeader
          :program="program"
          :index="index"
        >
          <ProgramHeader :program="program" />
        </AppHeader>

        <TeacherDashboardLayout
          :program="program"
          class="pt-24 lg:pt-52"
        />
      </section>
    </li>
  </ul>
</template>

<script>
import TeacherDashboardLayout from '@/layouts/TeacherDashboardLayout'
import AppHeader from '@/components/template/AppHeader'
import ProgramHeader from '@/components/pattern/ProgramHeader'
import { mapGetters } from 'vuex'

export default {
  name: 'TeacherDashboardView',
  status: 'prototype',
  release: '1.0.0',
  components: {
    TeacherDashboardLayout,
    AppHeader,
    ProgramHeader,
  },
  computed: {
    ...mapGetters(['activePrograms']),
    metaInfo () {
      return {
        title: this.$store.state.activeEventName || this.activePrograms[0].event_name,
      }
    },
    teacherPrograms () {
      const programs = []
      this.activePrograms.forEach(program => {
        program.participants.forEach(participant => {
          if (participant.id === this.$store.state.User.teacher_participant_id) {
            programs.push(program)
          }
        })
      })

      return programs
    },
  },
}
</script>
