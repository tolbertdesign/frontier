<template>
  <div class="flex items-center">
    <ul ref="appNavbar">
      <AppNavbarRoutes :routes="persistentNavRoutes" />
      <!-- <AppNavbarRoutes
        v-if="loggedIn"
        :routes="loggedInNavRoutes"
      />
      <AppNavbarRoutes
        v-else
        :routes="loggedOutNavRoutes"
      /> -->
    </ul>
    <ThemeToggle />
  </div>
</template>

<script>
import AppNavbarRoutes from '@/components/AppNavbarRoutes'
import ThemeToggle from '@/components/ThemeToggle'

export default {
  name: 'AppNavbar',
  components: { AppNavbarRoutes, ThemeToggle },
  data () {
    return {
      persistentNavRoutes: [
        {
          title: 'Dashboard',
          name: 'dashboard',
        },
        {
          title: 'Buy',
          name: 'buy',
        },
      ],
      loggedInNavRoutes: [
        {
          title: 'Add Contact',
          name: 'contact',
        },
      ],
      loggedOutNavRoutes: [
        {
          title: 'Changlog',
          name: 'changelog',
        },
      ],
    }
  },
}
</script>
