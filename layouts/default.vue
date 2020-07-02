<template>
  <div class="flex flex-col w-full min-h-screen">
    <TheNavbar />
    <!-- <TheHeader /> -->

    <main class="flex-1">
      <div class="px-4 pt-8 mx-auto sm:px-6 lg:px-8">
        <nuxt />
      </div>
    </main>

    <TheFooter />
  </div>
</template>

<script>
export default {
  name: 'DefaultLayout',
}
</script>
