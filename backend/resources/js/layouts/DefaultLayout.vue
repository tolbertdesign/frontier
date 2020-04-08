<template>
  <div class="relative flex flex-col min-h-screen bg-gray-50">
    <header class="app-header">
      <AppNav />
    </header>
    <main class="flex-1 w-full mx-auto overflow-auto">
      <slot>
        <div class="border-4 border-dashed border-gray-200 rounded-lg h-96" />
      </slot>
    </main>
    <AppFooter />
    <AppCookieConsent />
  </div>
</template>

<script>
import AppNav from '@/components/AppNav'
import AppFooter from '@/components/AppFooter'
import AppCookieConsent from '@/components/AppCookieConsent'

export default {
  name: 'DefaultLayout',
  components: { AppNav, AppCookieConsent, AppFooter },
  data: () => ({
    menuOpen: false,
    rewardsOpen: false,
  }),
  watch: {
    menuOpen: {
      immediate: true,
      handler (menuOpen) {
        if (menuOpen) {
          // document.body.style.setProperty('position', 'fixed')
          document.body.style.setProperty('overflow-y', 'scroll')
          // document.documentElement.style.setProperty('overflow', 'hidden')
          document.body.style.setProperty('overflow', 'hidden')
        } else {
          // document.body.style.setProperty('position', 'static')
          document.body.style.setProperty('overflow-y', 'auto')
          // document.documentElement.style.removeProperty('overflow', 'hidden')
          document.body.style.removeProperty('overflow')
        }
      },
    },
  },
  methods: {
    showAlerts (payload) {
      this.alertsOpen = payload
    },
    showMenu (payload) {
      this.menuOpen = payload
    },
  },
}
</script>
