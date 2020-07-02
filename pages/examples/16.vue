<template>
  <div class="flex items-center justify-center">
    <img class="w-80" src="/img/share-modal.png" />
    <div class="space-x-6 share-this">
      <EmailLink :program="$store.state.program" :link="shareEmailLink" />

      <SmsLink :program="$store.state.program" :link="shareSmsLink" />

      <ShareButton :program="$store.state.program" :link="shareCopyLink" />
    </div>
  </div>
</template>

<script>
export default {}
</script>
