<template>
  <div>
    <h1>{{ message }}</h1>
    <p>{{ type }}</p>
  </div>
</template>

<script>
export default {
  props: ['type'],
  data () {
    return {
      message: 'Hello Vue Testing',
    }
  },
  created () {
    this.message = 'Bye!'
  },
}
</script>
