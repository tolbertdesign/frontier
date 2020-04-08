<template>
  <ul class="page min-h-screen">
    <li
      v-for="(program, index) in activePrograms"
      :key="index"
    >
      <section
        v-show="$store.state.activeTab == index"
        :class="program.microsite.microsite_color_theme.theme_name"
        class="page min-h-screen"
      >
        <AppHeader
          :program="program"
          :index="index"
        >
          <ProgramHeader :program="program" />
        </AppHeader>

        <ParentDashboardLayout
          :program="program"
          class="pt-24 lg:pt-52"
        />
      </section>
    </li>
  </ul>
</template>

<script>
import ParentDashboardLayout from '@/layouts/ParentDashboardLayout'
import AppHeader from '@/components/template/AppHeader'
import ProgramHeader from '@/components/pattern/ProgramHeader'
import { mapGetters } from 'vuex'

export default {
  name: 'ParentDashboard',
  status: 'prototype',
  release: '1.0.0',
  components: {
    ParentDashboardLayout,
    AppHeader,
    ProgramHeader,
  },
  computed: {
    ...mapGetters(['activePrograms']),
  },
  metaInfo () {
    return {
      title: this.$store.state.activeEventName || this.activePrograms[0].event_name,
    }
  },
}
</script>
