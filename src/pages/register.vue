<template>
  <div id="register-page" class="container max-w-sm m-6">
    <UserRegistrationForm />
  </div>
</template>

<script>
import UserRegistrationForm from '@/components/UserRegistrationForm'

export default {
  name: 'RegisterPage',
  components: { UserRegistrationForm },
}
</script>
