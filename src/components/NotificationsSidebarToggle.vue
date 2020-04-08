<template>
  <a class="notifications-sidebar-toggle inline-block">
    <FontAwesomeLayers class="fa-2x">
      <FontAwesomeIcon
        icon="bell"
        class="text-white"
      />
      <FontAwesomeLayersText
        class="has-background-danger text-white rounded-full h-6 w-6 text-base font-bold"
        transform="down-4 right-8 shrink-2"
        value="20"
      />
    </FontAwesomeLayers>
  </a>
</template>

<script>
export default {
  name: 'NotificationsSidebarToggle',
  status: 'prototype',
  release: '1.0.0',
}
</script>
