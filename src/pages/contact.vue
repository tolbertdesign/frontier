<template>
  <div class="about">
    <ContactForm :edit="false" />
  </div>
</template>

<script>
import ContactForm from '@/components/ContactForm'

export default {
  name: 'ContactFormPage',
  components: {
    ContactForm,
  },
}
</script>
