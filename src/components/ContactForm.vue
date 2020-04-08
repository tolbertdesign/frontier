<template>
  <div class="contact-form">
    <div class="center">
      <h1>{{ editing ? 'Edit' : 'Add' }} Contact</h1>
    </div>

    <form novalidate @submit="save">
      <!-- First Name -->
      <div :class="{ 'is-invalid': errors.has('firstName') }">
        <label for="firstName">First Name</label>
        <input
          v-model="contact.firstName"
          v-validate="'required'"
          name="firstName"
          :disabled="sending"
        >
        <span v-if="errors.has('firstName')" class="error">First Name is required.</span>
      </div>

      <!-- Last Name -->
      <div :class="{ 'is-invalid': errors.has('lastName') }">
        <label for="lastName">Last Name</label>
        <input
          v-model="contact.lastName"
          v-validate="'required'"
          name="lastName"
          :disabled="sending"
        >
        <span v-if="errors.has('lastName')" class="error">Last Name is required.</span>
      </div>

      <!-- Address Line One -->
      <div :class="{ 'is-invalid': errors.has('addressLineOne') }">
        <label for="addressLineOne">Address Line 1</label>
        <input
          v-model="contact.addressLineOne"
          v-validate="'required'"
          name="addressLineOne"
          :disabled="sending"
        >
        <span v-if="errors.has('addressLineOne')" class="error">Address line 1 is required.</span>
      </div>

      <!-- Address Line Two -->
      <div :class="{ 'is-invalid': errors.has('addressLineTwo') }">
        <label for="addressLineTwo">Address Line 2</label>
        <input v-model="contact.addressLineTwo" name="addressLineTwo" :disabled="sending">
        <span v-if="errors.has('addressLineTwo')" class="error">Address line 2 is required</span>
      </div>

      <!-- City -->
      <div :class="{ 'is-invalid': errors.has('city') }">
        <label for="city">City</label>
        <input v-model="contact.city" v-validate="'required'" name="city" :disabled="sending">
        <span v-if="errors.has('city')" class="error">City is required.</span>
      </div>

      <!-- Country -->
      <div :class="{ 'is-invalid': errors.has('country') }">
        <label for="country">Country</label>
        <select
          v-model="contact.country"
          v-validate.continues="'required'"
          name="country"
          :disabled="sending"
        >
          <option v-for="country in countries" :key="country " :value="country">
            {{ country }}
          </option>
        </select>
        <span v-if="errors.firstByRule('country', 'required')" class="error">Country is required.</span>
      </div>

      <!-- Postal Code -->
      <div :class="{ 'is-invalid': errors.has('postalCode') }">
        <label for="postalCode">Postal Code</label>
        <input
          v-model="contact.postalCode"
          v-validate="{ required: true, regex: getPostalCodeRegex() }"
          name="postalCode"
          :disabled="sending"
        >
        <span
          v-if="errors.firstByRule('postalCode', 'required')"
          class="error"
        >Postal Code is required.</span>
        <span
          v-if="errors.firstByRule('postalCode', 'regex')"
          class="error"
        >Postal Code is invalid.</span>
      </div>

      <!-- Phone -->
      <div :class="{ 'is-invalid': errors.has('phone') }">
        <label for="phone">Phone</label>
        <input
          v-model="contact.phone"
          v-validate="{ required: true, regex: getPhoneRegex() }"
          name="phone"
          :disabled="sending"
        >
        <span v-if="errors.firstByRule('phone', 'required')" class="error">Phone is required.</span>
        <span v-if="errors.firstByRule('phone', 'regex')" class="error">Phone is invalid.</span>
      </div>

      <!-- Gender -->
      <div :class="{ 'is-invalid': errors.has('gender') }">
        <label for="gender">Gender</label>
        <select
          v-model="contact.gender"
          v-validate.continues="'required'"
          name="gender"
          md-dense
          :disabled="sending"
        >
          <option value="male">
            Male
          </option>
          <option value="female">
            Female
          </option>
        </select>
        <span v-if="errors.firstByRule('gender', 'required')" class="error">Gender is required.</span>
      </div>

      <!-- Age -->
      <div :class="{ 'is-invalid': errors.has('age') }">
        <label for="age">Age</label>
        <input
          id="age"
          v-model="contact.age"
          v-validate="'required|between:0,200'"
          type="number"
          name="age"
          autocomplete="age"
          :disabled="sending"
        >
        <span v-if="errors.firstByRule('age', 'required')" class="error">Age is required.</span>
        <span v-if="errors.firstByRule('age', 'between')" class="error">Age must be 0 and 200.</span>
      </div>

      <!-- Email -->
      <div :class="{ 'is-invalid': errors.has('email') }">
        <label for="email">Email</label>
        <input
          v-model="contact.email"
          v-validate="'required|email'"
          type="email"
          name="email"
          autocomplete="email"
          :disabled="sending"
        >
        <span v-if="errors.firstByRule('email', 'required')" class="error">Email is required.</span>
        <span v-if="errors.firstByRule('email', 'email')" class="error">Email is invalid.</span>
      </div>

      <!-- <md-progress-bar v-if="sending" md-mode="indeterminate" /> -->

      <button type="submit" class="">
        {{ editing ? 'Edit' : 'Create' }} Contact
      </button>
    </form>
  </div>
</template>

<script>
import { ValidationProvider } from 'vee-validate'
import { COUNTRIES } from '@/helpers'
import { contactMixin } from '@/mixins/contactMixin'

export default {
  name: 'ContactForm',
  components: { ValidationProvider },
  mixins: [contactMixin],
  props: {
    editing: Boolean,
    contactId: Number,
  },
  data () {
    return {
      sending: false,
      contact: {},
      countries: COUNTRIES.map(c => c.name),
    }
  },
  computed: {
    isFormDirty () {
      return Object.keys(this.fields).some(key => this.fields[key].dirty)
    },
    contacts () {
      return this.$store.state.contacts
    },
  },
  beforeMount () {
    this.contact = this.contacts.find(c => c.id == this.contactId) || {}
  },
  methods: {
    async save (evt) {
      evt.preventDefault()
      try {
        const result = await this.$validator.validateAll()
        if (!result) {
          return
        }
        if (this.editing) {
          await this.updateContact(this.contact, this.contactId)
          await this.getAllContacts()
          this.$emit('contactSaved')
        } else {
          await this.addContact(this.contact)
          await this.getAllContacts()
          this.$router.push('/')
        }
      } catch (error) {
        // eslint-disable-next-line
        console.log(error)
      }
    },
    async getAllContacts () {
      try {
        const response = await this.getContacts()
        this.$store.commit('setContacts', response.data)
      } catch (error) {
        // eslint-disable-next-line
        console.log(error)
      }
    },
    getPostalCodeRegex () {
      if (this.contact.country == 'United States') {
        return /^[0-9]{5}(?:-[0-9]{4})?$/
      } else if (this.contact.country == 'Canada') {
        return /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/
      }
      return /./
    },
    getPhoneRegex () {
      if (['United States', 'Canada'].includes(this.contact.country)) {
        return /^[2-9]\d{2}[2-9]\d{2}\d{4}$/
      }
      return /./
    },
  },
}
</script>

<style lang="pcss">
.contact-form {
  margin: 0 auto;
  width: 90%;
}
</style>
