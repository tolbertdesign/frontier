<template>
  <div>
    <form
      v-if="canEdit && unitRange.length > 0"
      class="select"
      @submit.prevent=""
    >
      <select
        v-model="newUnits"
        name="units"
        class="font-bold units-containers"
        @change="updateUnits()"
      >
        <option
          v-for="index in unitRange"
          :key="index"
          :value="index"
        >
          {{ index }}
        </option>
      </select>
    </form>
    <p
      v-else
      class="px-5 border units-container border-grey-light border-solid rounded sm:py-2 py-1 font-bold"
    >
      {{ newUnits }}
    </p>
  </div>
</template>

<script>
import SaveSuccessModal from '@/components/template/SaveSuccessModal'
import Blur from '@/mixins/Blur'

export default {
  name: 'UnitsForm',
  status: 'prototype',
  release: '1.0.0',
  mixins: [Blur],
  props: {
    participantUserId: {
      type: Number,
      default: null,
    },
    units: {
      type: Number,
      default: 0,
    },
    unitNamePlural: {
      type: String,
      default: 'Laps',
    },
    unitMax: {
      type: Number,
      default: 35,
    },
    canEdit: {
      type: Boolean,
      default: true,
    },
  },
  data () {
    return {
      unitRangeLow: 10,
      newUnits: null,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    successModalTitle () {
      return this.parseLanguage(this.lang.update_units_success_title, { name_plural: this.unitNamePlural })
    },
    successModalSubtitle () {
      return this.parseLanguage(this.lang.update_units_success_subtitle, { name_plural: this.unitNamePlural })
    },
    unitRange () {
      const range = []
      for (let i = this.unitRangeLow; i <= this.unitMax; i++) {
        range.push(i)
      }
      return range
    },
  },
  mounted () {
    if (this.units > 0) {
      this.newUnits = this.units
    }
  },
  methods: {
    updateUnits () {
      if (this.newUnits > 0 && this.newUnits <= this.unitMax) {
        this.$axon.update('users', this.participantUserId, {
          units: this.newUnits,
        }).then(response => {
          this.$buefy.modal.open({
            parent: this,
            component: SaveSuccessModal,
            hasModalCard: true,
            props: {
              title: this.successModalTitle,
              subtitle: this.successModalSubtitle,
              duration: 0,
            },
            canCancel: ['escape', 'outside'],
            onCancel: this.unBlur,
            width: 'auto',
          })
        }).catch(error => {
          console.log(error)
        })
      }
    },
  },
}
</script>
