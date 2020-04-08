<template>
  <label
    :class="className"
    :aria-checked="ariaChecked"
    role="checkbox"
  >
    <input
      :name="name"
      type="checkbox"
      class="v-switch-input"
      @change.stop="toggle"
    >
    <div
      :style="coreStyle"
      class="v-switch-core"
    >
      <div
        :style="buttonStyle"
        class="v-switch-button"
      >
        <i
          v-if="toggled"
          class="fas fa-check"
        />
      </div>
    </div>
    <template v-if="labels">
      <span
        v-if="toggled"
        :style="labelStyle"
        class="v-switch-label v-left"
        v-html="labelChecked"
      />
      <span
        v-else
        :style="labelStyle"
        class="v-switch-label v-right"
        v-html="labelUnchecked"
      />
    </template>
  </label>
</template>

<script>
const constants = {
  colorChecked: '#75C791',
  colorUnchecked: '#bfcbd9',
  cssColors: false,
  labelChecked: 'on',
  labelUnchecked: 'off',
  width: 54,
  height: 24,
  margin: 2,
  switchColor: '#fff',
}

const contains = (object, title) => {
  // eslint-disable-next-line
  return typeof object === 'object' && object.hasOwnProperty(title)
}

const px = v => v + 'px'

export default {
  name: 'ToggleButton',
  props: {
    value: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    name: {
      type: String,
      default: '',
    },
    sync: {
      type: Boolean,
      default: false,
    },
    speed: {
      type: Number,
      default: 300,
    },
    color: {
      type: [String, Object],
      default: '#ccc',
      validator (value) {
        return typeof value === 'object'
          ? (value.checked || value.unchecked)
          : typeof value === 'string'
      },
    },
    switchColor: {
      type: [String, Object],
      default: '#fff',
      validator (value) {
        return typeof value === 'object'
          ? (value.checked || value.unchecked)
          : typeof value === 'string'
      },
    },
    cssColors: {
      type: Boolean,
      default: false,
    },
    labels: {
      type: [Boolean, Object],
      default: false,
      validator (value) {
        return typeof value === 'object'
          ? (value.checked || value.unchecked)
          : typeof value === 'boolean'
      },
    },
    height: {
      type: Number,
      default: constants.height,
    },
    width: {
      type: Number,
      default: constants.width,
    },
  },
  data () {
    return {
      toggled: !!this.value,
    }
  },
  computed: {
    className () {
      const { toggled, disabled } = this

      return ['vue-js-switch', { toggled, disabled }]
    },

    ariaChecked () {
      return this.toggled.toString()
    },

    coreStyle () {
      return {
        width: px(this.width),
        height: px(this.height),
        backgroundColor: this.cssColors
          ? null
          : (this.disabled ? this.colorDisabled : this.colorCurrent),
        borderRadius: px(Math.round(this.height / 2)),
      }
    },

    buttonRadius () {
      return this.height - constants.margin * 2
    },

    distance () {
      return px(this.width - this.height + constants.margin)
    },

    buttonStyle () {
      return {
        width: px(this.buttonRadius),
        height: px(this.buttonRadius),
        transition: `transform ${this.speed}ms`,
        transform: this.toggled
          ? `translate3d(${this.distance}, 2px, 0px)`
          : null,
        background: this.switchColor ? this.switchColorCurrent : undefined,
      }
    },

    labelStyle () {
      return {
        lineHeight: px(this.height),
      }
    },

    colorChecked () {
      const { color } = this

      if (typeof color !== 'object') {
        return color || constants.colorChecked
      }

      return contains(color, 'checked')
        ? color.checked
        : constants.colorChecked
    },

    colorUnchecked () {
      const { color } = this

      return contains(color, 'unchecked')
        ? color.unchecked
        : constants.colorUnchecked
    },

    colorDisabled () {
      const { color } = this

      return contains(color, 'disabled')
        ? color.disabled
        : this.colorCurrent
    },

    colorCurrent () {
      return this.toggled
        ? this.colorChecked
        : this.colorUnchecked
    },

    labelChecked () {
      return contains(this.labels, 'checked')
        ? this.labels.checked
        : constants.labelChecked
    },

    labelUnchecked () {
      return contains(this.labels, 'unchecked')
        ? this.labels.unchecked
        : constants.labelUnchecked
    },

    switchColorChecked () {
      const { switchColor } = this

      return contains(switchColor, 'checked')
        ? switchColor.checked
        : constants.switchColor
    },

    switchColorUnchecked () {
      const { switchColor } = this

      return contains(switchColor, 'unchecked')
        ? switchColor.unchecked
        : constants.switchColor
    },

    switchColorCurrent () {
      const { switchColor } = this

      if (typeof switchColor !== 'object') {
        return switchColor || constants.switchColor
      }

      return this.toggled
        ? this.switchColorChecked
        : this.switchColorUnchecked
    },

  },
  watch: {
    value (value) {
      if (this.sync) {
        this.toggled = !!value
      }
    },
  },
  methods: {
    toggle (event) {
      this.toggled = !this.toggled
      this.$emit('input', this.toggled)
      this.$emit('change', {
        value: this.toggled,
        srcEvent: event,
      })
    },
  },
}
</script>
