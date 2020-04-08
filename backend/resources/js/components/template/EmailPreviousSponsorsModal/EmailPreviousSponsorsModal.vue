<template>
  <div class="m-4 rounded-xl overflow-hidden previous-sponsor-modal">
    <div class="card bg-blue">
      <div
        v-if="isSending"
        class="card-content pt-12 pb-12 px-4 text-white text-center"
      >
        <SendEnvelope />
        <p class="font-bold text-xl">
          {{ lang.email_send_to }}:
        </p>
        <p class="font-semibold pt-4">
          {{ previousSponsors.length }} <span>{{ lang.contact }}</span>
        </p>
      </div>
      <div
        v-else
        class="card-content pt-16 px-4 text-white text-center"
      >
        <SendEnvelope />
        <p class="font-medium text-lg">
          {{ lang.about_to_email_previous }}
        </p>
      </div>
      <div
        v-if="!isSending"
        class="card-footer border-t-0"
      >
        <div class="card-footer-item">
          <button
            class="w-24 sm:w-32 button inline-block mb-4 mx-2 is-danger is-rounded shadow font-bold"
            @click="close"
          >
            {{ lang.cancel }}
          </button>
          <button
            class="w-24 sm:w-32 button inline-block mb-4 mx-2 is-secondary is-rounded is-inverted shadow font-bold"
            @click="sendEmail"
          >
            {{ lang.send }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Blur from '@/mixins/Blur'

export default {
  name: 'EmailPreviousSponsorsModal',
  mixins: [Blur],
  props: {
    previousSponsors: {
      type: Array,
      default: null,
    },
    participantUserId: {
      type: Number,
      default: null,
    },
  },
  data () {
    return {
      isSending: false,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
  },
  methods: {
    sendEmail () {
      const sponsors = this.previousSponsors

      if (sponsors.length === 0) {
        this.close()
        return
      }

      const sponsorIds = sponsors.map(sponsor => sponsor.id)

      axios.post('/v3/api/previous-contact-enroll', {
        participantUserId: this.participantUserId,
        sponsorIds: sponsorIds,
      }).then(response => {
        this.isSending = true
        this.$emit('previousSponsorsEmailed', response.data.emailed, response.data.skipped)

        setTimeout(() => {
          this.close()
        }, 3000)
      }).catch(error => {
        console.error(error)
        setTimeout(() => {
          this.close()
        }, 3000)
      })
    },
    close () {
      this.$emit('close')
      this.unBlur()
    },
  },
}
</script>
