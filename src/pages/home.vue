<template>
  <div class="home">
    <div class="colors">
      <div
        v-for="(color, i) in colors"
        :key="i"
        class="color"
      >
        <div
          v-for="n in 9"
          :key="n"
          :class="['swatch', `${color}-${n}00`]"
        >
          {{ color }}
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      colors: ['teal', 'blue-grey', 'blue', 'red', 'yellow', 'purple'],
    }
  },
}
</script>

<style lang="scss" scoped>
.color {
  display: flex;
  // height: 15.99vh;
  > * {
    min-width: 10%;
    margin: $spacing-1;
  }
}
.swatch {
  padding: $spacing-3;
  &.teal-050 {
    background: $teal-050;
  }
  &.teal-100 {
    background: $teal-100;
  }
  &.teal-200 {
    background: $teal-200;
  }
  &.teal-300 {
    background: $teal-300;
  }
  &.teal-400 {
    background: $teal-400;
  }
  &.teal-500 {
    background: $teal-500;
  }
  &.teal-600 {
    background: $teal-600;
  }
  &.teal-700 {
    background: $teal-700;
  }
  &.teal-800 {
    background: $teal-800;
  }
  &.teal-900 {
    background: $teal-900;
  }

  &.blue-grey-050 {
    background: $blue-grey-050;
  }
  &.blue-grey-100 {
    background: $blue-grey-100;
  }
  &.blue-grey-200 {
    background: $blue-grey-200;
  }
  &.blue-grey-300 {
    background: $blue-grey-300;
  }
  &.blue-grey-400 {
    background: $blue-grey-400;
  }
  &.blue-grey-500 {
    background: $blue-grey-500;
  }
  &.blue-grey-600 {
    background: $blue-grey-600;
  }
  &.blue-grey-700 {
    background: $blue-grey-700;
  }
  &.blue-grey-800 {
    background: $blue-grey-800;
  }
  &.blue-grey-900 {
    background: $blue-grey-900;
  }

  &.blue-050 {
    background: $blue-050;
  }
  &.blue-100 {
    background: $blue-100;
  }
  &.blue-200 {
    background: $blue-200;
  }
  &.blue-300 {
    background: $blue-300;
  }
  &.blue-400 {
    background: $blue-400;
  }
  &.blue-500 {
    background: $blue-500;
  }
  &.blue-600 {
    background: $blue-600;
  }
  &.blue-700 {
    background: $blue-700;
  }
  &.blue-800 {
    background: $blue-800;
  }
  &.blue-900 {
    background: $blue-900;
  }

  &.red-050 {
    background: $red-050;
  }
  &.red-100 {
    background: $red-100;
  }
  &.red-200 {
    background: $red-200;
  }
  &.red-300 {
    background: $red-300;
  }
  &.red-400 {
    background: $red-400;
  }
  &.red-500 {
    background: $red-500;
  }
  &.red-600 {
    background: $red-600;
  }
  &.red-700 {
    background: $red-700;
  }
  &.red-800 {
    background: $red-800;
  }
  &.red-900 {
    background: $red-900;
  }

  &.yellow-050 {
    background: $yellow-050;
  }
  &.yellow-100 {
    background: $yellow-100;
  }
  &.yellow-200 {
    background: $yellow-200;
  }
  &.yellow-300 {
    background: $yellow-300;
  }
  &.yellow-400 {
    background: $yellow-400;
  }
  &.yellow-500 {
    background: $yellow-500;
  }
  &.yellow-600 {
    background: $yellow-600;
  }
  &.yellow-700 {
    background: $yellow-700;
  }
  &.yellow-800 {
    background: $yellow-800;
  }
  &.yellow-900 {
    background: $yellow-900;
  }

  &.purple-050 {
    background: $purple-050;
  }
  &.purple-100 {
    background: $purple-100;
  }
  &.purple-200 {
    background: $purple-200;
  }
  &.purple-300 {
    background: $purple-300;
  }
  &.purple-400 {
    background: $purple-400;
  }
  &.purple-500 {
    background: $purple-500;
  }
  &.purple-600 {
    background: $purple-600;
  }
  &.purple-700 {
    background: $purple-700;
  }
  &.purple-800 {
    background: $purple-800;
  }
  &.purple-900 {
    background: $purple-900;
  }
}

// $green-vivid-050
// $green-vivid-100
// $green-vivid-200
// $green-vivid-300
// $green-vivid-400
// $green-vivid-500
// $green-vivid-600
// $green-vivid-700
// $green-vivid-800
// $green-vivid-900
</style>
