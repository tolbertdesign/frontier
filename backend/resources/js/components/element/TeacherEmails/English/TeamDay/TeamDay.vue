<template>
  <p>
    To: School Families
    <br>
    When: Team Day 1
    <br>
    Subject: Help our class!
    <br><br>
    {{ props.event_name }} Families,
    <br><br>
    Our class is having a BLAST preparing for the  {{ props.event_name }} coming up soon! We've also begun
    learning how to choose to live with character every day through Booster's brand new character theme,
    MindSpark: Wild West. While they're teaming up with the MindSpark Kids to compete in character duels,
    your students will learn five 21st-century character traits that will help strengthen themselves and our world.
    Make sure to ask your students what they've learned each day, and together you can watch
    the story unfold on <a :href="`https://${props.link}`">{{ props.link }}</a>!
    <br><br>Remember, we need your help connecting to sponsors who can make a pledge to help our school!
    Please make sure all pledges for the  {{ props.event_name }} are entered on <a :href="`https://${props.link}`">{{ props.link }}</a>.
    The more pledges we get, the more incentives our class earns on our Pledge-O-Meter.
    <br><br>Thank you for your generosity and support of our school. If you have any questions, please let me know.
    <br><br>Have a great day!
    <br><br>P.S. Make sure to register your child on <a :href="`https://${props.link}`">{{ props.link }}</a>.
    Search for your school or use our school registration code:
    <br><strong>{{ props.registration_code }}</strong><br>
  </p>
</template>

<script>
export default {
  name: 'TeamDay',
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
