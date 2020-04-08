<template>
  <p>
    To: School Families
    <br>
    When: Day After Event
    <br>
    Subject: Thank you for your support!
    <br><br>
    {{ props.event_name }} Families,
    <br><br>
    Thank you so much for supporting this year’s <strong> {{ props.event_name }}!</strong>
    The program was a huge success, and I know everyone had so much fun! There’s just one more thing left to do.
    <br><br>
    <strong>We need your help collecting all of our pledges.</strong>
    As a class, we raised <strong>${{ props.class_pledge_total }}</strong> — our goal is to collect 100% of all pledges by {{ props.due_date }}.
    <br><br>All sponsors that included their email address when making a pledge will receive an email reminder and instructions to pay for their pledge.
    Please reach out to those sponsors who did NOT include their email address to let them know they can send cash or check to you, which will then be sent to school in your child's collection envelope (coming home soon).
    <br><br>Finally, please encourage your student to thank all of their sponsors for helping our school!
    <br><br>Thank you again for your support! Let me know if you have any questions.<br>
  </p>
</template>

<script>
export default {
  name: 'DayAfterFunrun',
  status: 'prototype',
  release: '1.0.0',
  props: {
    props: {
      type: Object,
      default: () => {},
    },
  },
}
</script>
