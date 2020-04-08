<template>
  <aside class="app-notifications-sidebar sidebar column is-3 bg-white is-paddingless mt-3">
    <BMessage
      title="Alert"
      class="is-marginless has-background-white"
    >
      <div class="border-b py-4">
        <h2 class="font-bold">
          Thomas Jefferson Color Run
        </h2>
        <p>An easy and fun way to get started helping our school is creating your Student Star Video!  Just upload a photo of your child, and we will create a fun video starring your student.  You can share with friends and family to help ask for pledges! Thank you for supporting our school!</p>
      </div>

      <div class="border-b py-4">
        <h2 class="font-bold">
          Thomas Jefferson Color Run
        </h2>
        <p>We hope you are having a GREAT weekend! Just a reminder that today is the LAST day to get pledges to earn the weekend challenge! Just a $90 flat donation for the Flick Football set! Challenge ends tomorrow morning at 8:00am. Thank you for helping our school!</p>
      </div>
    </BMessage>
  </aside>
</template>
<script>
export default {
  name: 'AppNotificationsSidebar',
  status: 'prototype',
  release: '1.0.0',
  methods: {
    openNav () {
      alert('Open Nav')
    },
  },
}
</script>
