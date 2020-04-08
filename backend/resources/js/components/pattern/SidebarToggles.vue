<template>
  <nav class="sidebar-toggles bg-transparent flex items-center justify-end p-8 pb-4">
    <MenuSidebarToggle v-model="menuOpened" />
    <NotificationsSidebarToggle />
  </nav>
</template>

<script>
import NotificationsSidebarToggle from '@/components/pattern/NotificationsSidebarToggle'
import MenuSidebarToggle from '@/components/pattern/MenuSidebarToggle'

export default {
  name: 'SidebarToggles',
  status: 'prototype',
  release: '1.0.0',
  components: {
    MenuSidebarToggle,
    NotificationsSidebarToggle,
  },
  data () {
    return {
      menuOpened: false,
    }
  },
  methods: {
    showMenu () {
      this.$buefy.toast('Show menu')
    },
  },
}
</script>
