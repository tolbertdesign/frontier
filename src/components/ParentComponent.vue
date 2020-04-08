<template>
  <div>
    <ChildComponent v-for="item in items" :key="item" @custom="onCustom">
      {{ item }}
    </ChildComponent>
    <p v-if="emitted">
      Emitted!
    </p>
  </div>
</template>

<script>
import ChildComponent from '@/components/ChildComponent'

export default {
  name: 'ParentComponent',
  components: { ChildComponent },
  data () {
    return {
      emitted: false,
      items: ['item1', 'item2', 'item3'],
    }
  },
  methods: {
    onCustom () {
      this.emitted = true
    },
  },
}
</script>
