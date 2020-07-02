<template>
  <div class="mx-8 border-b border-gray-200">
    <nav class="flex -mb-px">
      <NuxtLink
        to="/examples/1"
        class="px-1 py-4 text-sm font-medium leading-5 whitespace-no-wrap border-b-2 border-transparent"
        active-class="text-indigo-600 border-indigo-500"
      >
        My Account
      </NuxtLink>

      <NuxtLink
        to="/examples/2"
        class="px-1 py-4 ml-8 text-sm font-medium leading-5 whitespace-no-wrap border-b-2 border-transparent"
        active-class="text-indigo-600 border-indigo-500"
      >
        Company
      </NuxtLink>

      <NuxtLink
        to="/examples/3"
        class="px-1 py-4 ml-8 text-sm font-medium leading-5 whitespace-no-wrap border-b-2 border-transparent"
        active-class="text-indigo-600 border-indigo-500"
      >
        Team Members
      </NuxtLink>
    </nav>
  </div>
</template>

<script>
export default {}
</script>
