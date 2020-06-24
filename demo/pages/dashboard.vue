<template>
  <div>
    <p>Name: {{ $auth.user.name }}</p>
    <p>Name: {{ $auth.user.email }}</p>
  </div>
</template>

<script>
export default {
  middleware: 'auth',
}
</script>
