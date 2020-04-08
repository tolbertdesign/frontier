<template>
  <div>
    <SchoolSearch
      lang=""
      search-url=""
      school-url=""
    />
    <!-- <PaymentForm /> -->
  </div>
</template>

<script>
import SchoolSearch from '@/components/SchoolSearch'
// import PaymentForm from '@/components/PaymentForm'

export default {
  name: 'BuyPage',
  components: {
    SchoolSearch,
    // PaymentForm ,
  },
}
</script>
