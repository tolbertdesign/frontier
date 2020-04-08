<template>
  <div id="welcome-page" class="container mx-auto max-w-sm m-6">
    <UserLoginForm :msg="$t('welcome')" />
  </div>
</template>

<script>
import UserLoginForm from '@/components/UserLoginForm'

export default {
  name: 'WelcomePage',
  components: { UserLoginForm },
  metaInfo () {
    return { title: this.$t('welcome') }
  },
  computed: {
    tabs () {
      return [
        {
          icon: 'user',
          name: this.$t('profile'),
          route: 'settings.profile',
        },
        {
          icon: 'lock',
          name: this.$t('password'),
          route: 'settings.password',
        },
      ]
    },
  },
}
</script>
