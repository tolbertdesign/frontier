<template>
  <footer>
    <p class="text-sm text-center">
      {{ $store.state.lang.contact_us_at }}
      <a href="mailto:support@boosterthon.com">support@boosterthon.com</a>
      {{ $store.state.lang.for_any_questions }} |
      {{ $store.state.lang.by_continuing_you_agree }}
      <PrivacyPolicyButton :prevent-background-scrolling="true" />.
    </p>
  </footer>
</template>

<script>
import PrivacyPolicyButton from '@/components/PrivacyPolicyButton'

export default {
  name: 'AppFooter',
  components: {PrivacyPolicyButton},
}
</script>
