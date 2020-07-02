<template>
  <div>
    schools
  </div>
</template>

<script>
export default {
  props: {
    schools: {
      type: Array,
      default: () => [
        {
          id: 1,
          name: '',
          type: '',
          city: '',
          state: '',
        },
      ],
    },
  },
}
</script>
