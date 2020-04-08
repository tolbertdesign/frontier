<template>
  <p>
    To: Classroom Families
    <br>When: Any Team Day (repeat as necessary)
    <br>Subject: Check out our progress!
    <br><br>
    {{ props.event_name }} Families,
    <br><br>Our class is having a great time learning all about how to choose character every day! Make sure to check in with your student
    today to see what they've been learning through MindSpark: Wild West!
    <br><br>I wanted to give you an update on our class' progress! Our class has reached
    <strong>${{ props.class_pledge_total }}</strong> on our Pledge-O-Meter. We think we can make it even further to help our school!
    <br><br><strong>Will you help us by reaching out to one or two more sponsors tonight?</strong>
    <br><br>If you haven't yet registered your student on <a :href="`https://${props.link}`">{{ props.link }}</a>
    don’t worry, there's still time to do it! Plus, once your student is registered, you'll find lots of fun,
    easy ways to reach out to sponsors through our Easy Emailer, Facebook Share Button, or even the Student Star Video!
    <br><br>Thank you for your support of our school!
    <br><br>Let me know if you have any questions!
    <br><br>P.S. The EASIEST way to ask for pledges is to simply click the “Share on Facebook” button on your student's pledge page.
    On average, sharing a pledge on Facebook increases total pledges by almost
    <strong>$50</strong> with a single click!
  </p>
</template>

<script>
export default {
  name: 'TeamDayTwo',
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
