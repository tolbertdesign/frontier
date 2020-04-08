<template>
  <div id="login-page" class="container max-w-sm m-6">
    <UserLoginForm />
  </div>
</template>

<script>
import UserLoginForm from '@/components/UserLoginForm'

export default {
  name: 'LoginPage',
  components: { UserLoginForm },
}
</script>
