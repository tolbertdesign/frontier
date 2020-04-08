<template>
  <p>
    To: School Families
    <br>When: Day Before Weekend Begins (typically Friday)
    <br>Subject: Special Weekend Challenge!
    <br><br>{{ props.event_name }} Families,
    <br><br>Thank you again for supporting our school through the <strong>{{ props.event_name }}!</strong>
    <br><br>This weekend we are issuing a special challenge! Your child can earn a bonus prize simply by getting a qualifying pledge
    <strong>this weekend only.</strong> Check out <a :href="`https://${props.link}`">{{ props.link }}</a> for details!
    <br><br>And if you're looking for the easiest way to ask for a pledge, just upload a photo
    of your student to <a :href="`https://${props.link}`">{{ props.link }}</a>
    to create a personalized Student Star Video. This fun, hilarious video starring your child can be shared by
    email or social media to connect with sponsors and ask for a pledge.
    <br><br>Thank you again for helping our class!
    <br><br>P.S. - If you haven't registered your child on <a :href="`https://${props.link}`">{{ props.link }}</a>,
    search for your school or use our school registration code: <strong>{{ props.registration_code }}</strong>
    <br>
  </p>
</template>

<script>
export default {
  name: 'WeekendChallenge',
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
