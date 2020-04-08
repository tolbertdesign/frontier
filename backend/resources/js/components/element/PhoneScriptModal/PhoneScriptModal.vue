<template>
  <div class="phone-script-modal m-4 rounded-xl overflow-hidden shadow-lg">
    <div class="bg-white">
      <header class="modal-card-head bg-white relative items-start">
        <p class="font-bold modal-card-title text-center text-xl">
          {{ lang.header }}
          <!-- <span class="script-header text-center">{{ lang.header }}</span> -->
        </p>
      </header>
      <section class="modal-card-body has-text-centered">
        <p
          class="script-body"
          v-html="lang.p1"
        />
        <br>
        <p
          class="script-body"
          v-html="lang.p2"
        />
        <br>
        <p
          class="script-body"
          v-html="parseLanguage(lang.p3, {event_name: program.event_name})"
        />
        <br>
        <p
          class="script-body"
          v-html="parseLanguage(lang.p4, {event_name: program.event_name,
                                          range_low: program.unit_range_low,
                                          range_high: program.unit_range_high,
                                          unit_max: program.unit_max_charge,
                                          unit_types: program.unit.name_plural})"
        />
        <br>
        <p
          class="script-body"
          v-html="lang.p5"
        />
        <br>
        <p
          class="script-body"
          v-html="parseLanguage(lang.p6, {unit_type: program.unit.name.toUpperCase()})"
        />
        <br>
        <p
          class="script-body"
          v-html="parseLanguage(lang.p7, {unit_type: program.unit.name})"
        />
        <br>
        <p
          class="script-body"
          v-html="parseLanguage(lang.p8, {unit_types: program.unit.name_plural})"
        />
        <br>
        <p
          class="script-body"
          v-html="lang.p9"
        />
        <br>
        <button
          class="px-8 rounded-full button inline-block is-secondary shadow-md font-bold centered close-button"
          @click="close()"
        >
          {{ lang.close }}
        </button>
      </section>
    </div>
  </div>
</template>

<script>
import Blur from '@/mixins/Blur'

export default {
  name: 'PhoneScriptModal',
  mixins: [Blur],
  props: {
    program: {
      type: Object,
      default: () => {},
    },
  },
  computed: {
    lang () {
      return this.$store.state.lang.how_to_get_pledges.phone_script
    },
  },
  methods: {
    close () {
      this.$emit('close')
      this.unBlur()
    },
  },
}
</script>
