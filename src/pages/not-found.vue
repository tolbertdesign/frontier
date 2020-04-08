<template>
  <div id="not-found-page" class="container max-w-sm m-6">
    <h1>Oops!</h1>
    <h3>The {{ resource }} you're looking for is not here.</h3>
    <router-link :to="{ name: 'events' }">
      Back to the home page
    </router-link>
  </div>
</template>

<script>
export default {
  name: 'NotFound',
  HTTPStatus: 404,
  props: {
    resource: {
      type: String,
      required: true,
    },
  },
}
</script>
