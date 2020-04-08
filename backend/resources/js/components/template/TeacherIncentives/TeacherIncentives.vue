<template>
  <div class="text-center">
    <!-- Teacher incentive image for mobile -->
    <img
      :src="`https://${this.$store.state.s3Bucket}.s3.amazonaws.com/assets/images/teacher_incentives_mobile.png`"
      class="p-2 md:hidden"
    >

    <!-- Teacher incentive image for desktop -->
    <img
      :src="`https://${this.$store.state.s3Bucket}.s3.amazonaws.com/assets/images/teacher_incentives_desktop.png`"
      class="p-2 md:inline hidden"
    >
  </div>
</template>

<script>
export default {
  name: 'TeacherIncentives',
  status: 'prototype',
  release: '1.0.0',
}
</script>
