<template>
  <div class="container mx-auto mt-16">
    Welcome to Frontier Log in with one of the following: Github Email

    <h1>Programs</h1>
    <input v-model="q" type="search" @input="$fetch" />

    <pre>{{ programs }}</pre>
  </div>
</template>

<script>
export default {
  name: 'IndexPage',
  async fetch() {
    // $content('articles', params.slug)
    // /_content/articles/hello-world
    // http://localhost:3000/_content/articles?only=title&only=description&limit=10
    this.programs = await this.$content('programs')
      .only(['name', 'event_name', 'client_goal', 'microsite'])
      .sortBy('name')
      // .where({name: 'Test Program'})
      .fetch()
  },
  data() {
    return {
      programs: [],
      q: '',
    }
  },
}
</script>
