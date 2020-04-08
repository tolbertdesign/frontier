<template>
  <p>
    To: School Families
    <br>
    When: Day Before Event
    <br>
    Subject: The {{ props.event_name }} is tomorrow!
    <br><br>
    {{ props.event_name }} Families,
    <br><br>
    The {{ props.event_name }} is tomorrow! Thank you to all of our families who have been working hard to raise funds for our school.
    We truly appreciate your support!<br><br>There is only one day left in the program.
    That makes tonight <strong>THE LAST NIGHT FOR PLEDGING before the {{ props.event_name }}</strong>.
    <br><br><strong>Would you consider reaching out to one or two more sponsors tonight?</strong>
    <br><br>If you have any questions, please let me know. We hope to see you and your family tomorrow at the BIG event!
    <br><br>Have a wonderful day!
    <br><br>P.S. – It’s not too late to register your child on <a :href="`https://${props.link}`">{{ props.link }}</a>!
    To sign up, search for your school or use our school registration code: <strong>{{ props.registration_code }}</strong>
    <br>
  </p>
</template>

<script>
export default {
  name: 'DayBeforeFunrun',
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
