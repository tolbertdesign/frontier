<template>
  <div class="m-4 rounded-xl overflow-hidden">
    <div
      v-if="isSending"
      class="card bg-blue w-full"
    >
      <div
        v-if="isSending"
        class="card-content py-16 text-white text-center"
      >
        <SendEnvelope />
        <p class="font-bold text-xl">
          {{ lang.contact_removed }}
        </p>
      </div>
    </div>
    <div
      v-else
      class="card bg-blue w-full"
    >
      <header class="card-header p-4 shadow-none">
        <p class="flex justify-between items-center text-center modal-card-title text-white">
          <span style="width: 24px; height: 48px;" />
          <span class="flex-1 text-center text-2xl font-bold">Remove Contact</span>
          <a
            href="#"
            class="text-white self-start"
            style="width: 24px; height: 48px;"
            @click.prevent="closeModal"
          >
            <span class="icon">
              <FontAwesomeIcon
                :icon="['fas', 'times']"
                size="xs"
              />
            </span>
          </a>
        </p>
      </header>
      <div
        class="card-content text-lg text-white text-center"
      >
        <p class="px-2">
          Removing a contact will remove them from this list for the current email campaign.
        </p>
      </div>
      <div class="card-footer border-t-0">
        <div class="card-footer-item flex-col mb-4">
          <button
            class="px-8 rounded-full button inline-block is-danger shadow-md font-bold"
            @click="removeContact"
          >
            Remove Contact
          </button>
        </div>
      </div>

    </div>

  </div>
</template>

<script>
import { mapState } from 'vuex'
import Blur from '@/mixins/Blur'

export default {
  name: 'RemoveContactModal',
  mixins: [Blur],
  props: {
    contact: {
      type: Object,
      default: null,
    },
  },
  data: function () {
    return {
      isSending: false,
    }
  },
  computed: {
    ...mapState(['lang']),
  },
  methods: {
    removeContact () {
      // call action to remove contact
      this.isSending = true
      this.$store
        .dispatch(
          'removeContact',
          {
            contact: this.contact,
          },
        )
        .then(() => {
          setTimeout(() => {
            this.closeModal()
            this.isSending = false
          }, 2000)
        })
    },
    closeModal () {
      this.$emit('close')
      this.unBlur()
    },
  },
}
</script>
