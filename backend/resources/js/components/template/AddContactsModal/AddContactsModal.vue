<template>
  <div class="overflow-hidden rounded-xl max-w-xs mx-auto">
    <div class="card bg-blue w-full">
      <header
        v-if="!isSending"
        class="card-header bg-blue text-white border-b-0 p-4 shadow-none"
      >
        <p class="flex justify-between items-center text-center modal-card-title text-white">
          <span style="width: 24px; height: 48px;" />
          <span class="flex-1 text-center text-2xl font-bold">{{ lang.add_contact }}</span>
          <a
            href="#"
            class="text-white self-start"
            style="width: 24px; height: 48px;"
            @click.prevent="close"
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
        v-if="isSending"
        class="card-content w-80 py-16 text-white text-center"
      >
        <SendEnvelope />
        <p class="font-bold text-xl">
          {{ lang.email_sent }}
        </p>
      </div>
      <div
        v-else
        class="card-content animated fadeIn animated-slow pt-0 text-white bg-blue"
      >
        <div class="sm:w-64 mx-auto">
          <BField
            :message="firstNameErrors"
          >
            <BInput
              v-model="contact.firstName"
              :placeholder="lang.first_name"
              expanded
            />
          </BField>
          <BField
            :message="lastNameErrors"
          >
            <BInput
              v-model="contact.lastName"
              :placeholder="lang.last_name"
              expanded
            />
          </BField>
          <BField
            :message="emailAddressErrors"
          >
            <BInput
              v-model="contact.emailAddress"
              :placeholder="lang.email_address"
              expanded
            />
          </BField>
        </div>
      </div>
      <div
        v-if="!isSending"
        class="card-footer border-t-0"
      >
        <div class="card-footer-item flex-col mb-4">
          <button
            class="button is-medium px-16 py-2 bg-white text-secondary rounded-full inline-block font-semibold shadow"
            @click.prevent="enrollContacts"
          >
            {{ lang.send_email }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AddContactsButtons from '@/components/template/AddContactsButtons'
import Blur from '@/mixins/Blur'

export default {
  name: 'AddContactsModal',
  components: {
    AddContactsButtons,
  },
  mixins: [Blur],
  data () {
    return {
      isSending: false,
      validationError: '',
      contact: {
        firstName: '',
        lastName: '',
        emailAddress: '',
      },
      templates: [
        {
          id: 1,
          isOpen: false,
        },
        {
          id: 2,
          isOpen: false,
        },
        {
          id: 3,
          isOpen: false,
        },
      ],
      errors: null,
    }
  },
  computed: {
    firstNameErrors () {
      if (this.errors) {
        return this.errors['contacts.0.firstName']
      }
    },
    lastNameErrors () {
      if (this.errors) {
        return this.errors['contacts.0.lastName']
      }
    },
    emailAddressErrors () {
      if (this.errors) {
        return this.errors['contacts.0.emailAddress']
      }
    },
    lang () {
      return this.$store.state.lang
    },
  },
  methods: {
    close () {
      this.$emit('close')
      this.unBlur()
    },
    enrollContacts () {
      this.validationError = ''
      axios.post('/v3/api/enroll-contacts', {
        contacts: [
          this.contact,
        ],
        participantUserId: this.$route.params.participantUserId,
      }).then(response => {
        const sponsorRecord = response.data[0]
        const contact = {
          first_name: sponsorRecord['firstName'],
          last_name: sponsorRecord['lastName'],
          email: sponsorRecord['emailAddress'],
          participant_user_id: this.$route.params.participantUserId,
        }
        this.$emit('addContactToDisplay', contact)

        this.isSending = true
        setTimeout(() => {
          this.close()
        }, 3000)
      }).catch(error => {
        this.validationError = error.response.data.message
        this.isSending = false
        this.errors = error.response.data.errors
        this.validationError = error.response.data.message
      })
    },
  },
}
</script>
