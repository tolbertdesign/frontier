<template>
  <div class="banner_dashboard mx-auto">
    <a
      href="/v3/tkdashboard/?redirect=home/dashboard?dashboardBetaOptOut=true"
      class="bg-grey"
    >
      <span class="message md:underline md:leading-normal leading-tight bg-grey text-white">
        {{ lang.beta_banner_return }}
      </span>
    </a>
  </div>
</template>

<script>
export default {
  computed: {
    lang () {
      return this.$store.state.lang
    },
  },
}
</script>
