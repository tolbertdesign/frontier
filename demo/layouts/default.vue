<template>
  <div class="flex flex-col w-full min-h-screen">
    <TheNavbar />
    <!-- <TheHeader /> -->

    <main class="flex-1">
      <nuxt />
    </main>

    <TheFooter />
  </div>
</template>

<script>
export default {
  name: 'DefaultLayout',
}
</script>
