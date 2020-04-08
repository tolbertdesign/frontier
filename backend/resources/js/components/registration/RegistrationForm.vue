<template>
  <div>
    <div class="registration-form-constraint d-block mx-auto">
      <h2 class="mt-4">
        {{ lang.sign_up }}
      </h2>
      <form @submit="_verify($event)">
        <input
          :value="csrf"
          type="hidden"
          name="_token"
        >
        <input
          v-model="$parent.teacher_registration_code"
          name="teacher_registration_code"
          class="form-control mb-3"
          type="hidden"
        >
        <div class="form-group mx-auto">
          <label class="sr-only">{{ lang.first_name }}</label>
          <input
            v-model="first_name"
            :class="[errors.first_name != undefined ? 'is-invalid' : '', 'form-control text-16']"
            :placeholder="lang.first_name"
            :oninvalid="`setCustomValidity('${ errorMessages.firstName }')`"
            oninput="setCustomValidity('')"
            type="text"
            name="first_name"
            required
            @change.once="handleInputChange($event)"
          >
          <div
            v-if="errors.first_name != undefined"
            class="error-msg"
          >
            {{ errors.first_name[0] }}
          </div>
        </div>
        <div class="form-group  mx-auto">
          <label class="sr-only">{{ lang.last_name }}</label>
          <input
            v-model="last_name"
            :class="[errors.last_name != undefined ? 'is-invalid' : '', 'form-control text-16']"
            :placeholder="lang.last_name"
            :oninvalid="`setCustomValidity('${ errorMessages.lastName }')`"
            oninput="setCustomValidity('')"
            type="text"
            name="last_name"
            required
            @change.once="handleInputChange($event)"
          >
          <div
            v-if="errors.last_name != undefined"
            class="error-msg"
          >
            {{ errors.last_name[0] }}
          </div>
        </div>
        <div
          v-if="!isSocialRegistration"
          class="form-group mx-auto"
        >
          <label class="sr-only">{{ lang.email }}</label>
          <input
            v-model="email"
            :class="[errors.email != undefined ? 'is-invalid' : '', 'form-control text-16']"
            :placeholder="lang.email"
            :oninvalid="`setCustomValidity('${ errorMessages.email[0] }')`"
            oninput="setCustomValidity('')"
            type="email"
            name="email"
            required
            @change="handleInputChange($event)"
          >
          <div
            v-if="email_registered"
            id="email-registered-error"
            class="error-msg text-center p-3"
          >
            {{ lang.email_registered }}
          </div>
          <a
            v-if="email_registered"
            class="btn btn-primary btn-round d-block w-200px mx-auto mb-3 btn-drop-shadow text-18 text-white"
            href="/v3/password/reset"
          >{{ lang.reset_password }}</a>
          <div
            v-if="errors.email != undefined"
            class="error-msg"
          >
            {{ errors.email[0] }}
          </div>
        </div>
        <div
          v-if="!email_registered && !isSocialRegistration"
          class="form-group mx-auto"
        >
          <label class="sr-only">{{ lang.confirm_email }}</label>
          <input
            v-model="email_confirmation"
            :class="[errors.email_confirmation != undefined ? 'is-invalid' : '', 'form-control text-16']"
            :placeholder="lang.confirm_email"
            :oninvalid="`setCustomValidity('${ errorMessages.emailConfirmation }')`"
            oninput="setCustomValidity('')"
            type="email"
            name="email_confirmation"
            required
          >
          <div
            v-if="errors.email_confirmation != undefined"
            class="error-msg"
          >
            {{ errors.email_confirmation[0] }}
          </div>
        </div>
        <div
          v-if="!email_registered && !isSocialRegistration"
          class="form-group mx-auto"
        >
          <p class="mx-auto text-14 text-left fw-200 mb-2">
            {{ lang.password_requirements }}
          </p>
          <label class="sr-only">{{ lang.password }}</label>
          <input
            v-model="password"
            :title="lang.password_requirements"
            :class="[errors.password != undefined ? 'is-invalid' : '', 'form-control text-16']"
            :placeholder="lang.password"
            :oninvalid="`setCustomValidity('${ errorMessages.password }')`"
            oninput="setCustomValidity('')"
            type="password"
            name="password"
            pattern=".{7,20}"
            required
            @change.once="handleInputChange($event)"
          >
          <div
            v-if="errors.password != undefined"
            class="error-msg"
          >
            {{ errors.password[0] }}
          </div>
        </div>
        <div
          v-if="!email_registered"
          class="form-group position-relative"
        >
          <label class="sr-only">{{ lang.phone }}</label>
          <the-mask
            v-model="phone"
            :class="[errors.phone != undefined ? 'is-invalid' : '', 'form-control text-16']"
            :placeholder="lang.phone_number"
            type="tel"
            name="phone"
            maxlength="14"
            mask="(###) ###-####"
            required
            @change.native.once="handleInputChange($event)"
          />
          <i
            :title="lang.phone_tip"
            class="fas fa-info-circle phone-tip"
            data-toggle="tooltip"
            data-placement="top"
          />
          <div
            v-if="errors.phone != undefined"
            class="error-msg"
          >
            {{ errors.phone[0] }}
          </div>
        </div>
        <p
          v-if="!email_registered"
          class="mx-auto text-14 text-left fw-200 mb-2"
        >{{ lang.birthdate }}</p>
        <div
          v-if="!email_registered"
          class="form-group d-flex mb-2 positon-relative"
        >
          <select
            v-model="month"
            :class="[errors.month != undefined ? 'is-invalid' : '', 'form-control']"
            name="month"
            required="required"
            @change.once="handleInputChange($event)"
          >
            <option
              class="p-0"
              value="0"
              disabled
            >{{ lang.month }}</option>
            <option
              class="p-0"
              value="1"
            >{{ lang.Jan }}</option>
            <option
              class="p-0"
              value="2"
            >{{ lang.Feb }}</option>
            <option
              class="p-0"
              value="3"
            >{{ lang.Mar }}</option>
            <option
              class="p-0"
              value="4"
            >{{ lang.Apr }}</option>
            <option
              class="p-0"
              value="5"
            >{{ lang.May }}</option>
            <option
              class="p-0"
              value="6"
            >{{ lang.Jun }}</option>
            <option
              class="p-0"
              value="7"
            >{{ lang.Jul }}</option>
            <option
              class="p-0"
              value="8"
            >{{ lang.Aug }}</option>
            <option
              class="p-0"
              value="9"
            >{{ lang.Sep }}</option>
            <option
              class="p-0"
              value="10"
            >{{ lang.Oct }}</option>
            <option
              class="p-0"
              value="11"
            >{{ lang.Nov }}</option>
            <option
              class="p-0"
              value="12"
            >{{ lang.Dec }}</option>
          </select>
          <select
            v-model="day"
            :class="[errors.day != undefined ? 'is-invalid' : '', 'form-control']"
            name="day"
            required
            @change.once="handleInputChange($event)"
          >
            <option
              class="p-0"
              value="0"
              disabled
            >{{ lang.day }}</option>
            <option
              v-for="i in maxNumberOfDays(month, year)"
              :key="i"
              :value="i"
              class="p-0"
            >{{ i }}</option>
          </select>
          <select
            v-model="year"
            :class="[errors.year != undefined ? 'is-invalid' : '', 'form-control']"
            name="year"
            required
            @change.once="handleInputChange($event)"
          >
            <option
              class="p-0"
              value="0"
              disabled
            >{{ lang.year }}</option>
            <option
              v-for="i in years"
              :key="i"
              :value="i"
              class="p-0"
            >{{ i }}</option>
          </select>
          <i
            :title="lang.birthdate_tip"
            class="fas fa-info-circle birthday-tip position-relative"
            data-toggle="tooltip"
            data-placement="top"
          />
          <div
            v-if="errors.year != undefined || errors.month != undefined || errors.day != undefined"
            class="error-msg"
          >
            {{ lang.birthdate_error }}
          </div>
        </div>
        <div
          v-if="!email_registered"
          class="form-group mx-auto mb-2 pb-3 position-relative"
        >
          <label class="text-11 my-0 fw-200">
            <input
              v-model="marketing_opt_in"
              type="checkbox"
              name="marketing_opt_in"
              class="mr-1"
              value="true"
            >
            {{ lang.marketing_opt_in }}
          </label>
          <i
            :title="lang.marketing_opt_in_tip"
            class="fas fa-info-circle marketing-opt-in-tip"
            data-toggle="tooltip"
            data-placement="top"
          />
        </div>
        <div
          v-if="errors.teacher_registration_code != undefined"
          class="error-msg mb-2 text-center"
        >
          {{ errors.teacher_registration_code[0] }}
        </div>
        <button
          v-if="!email_registered"
          id="create_account"
          type="submit"
          class="btn btn-primary btn-round d-block w-200px mx-auto mb-3 btn-drop-shadow text-18"
        >
          {{ lang.create_account }}
        </button>
        <p
          v-if="!email_registered"
          class="text-14 my-0 fw-200"
        >{{ lang.sign_in_message }}
          <a
            :href="login_url"
            class="parent_login fw-600"
          >{{ lang.sign_in }}</a>
        </p>
      </form>
    </div>
  </div>

</template>

<script>
import { startCase, camelCase, capitalize } from 'lodash'

export default {
  props: {
    csrf: {
      type: String,
      default: '',
    },
    login_url: {
      type: String,
      default: '',
    },
    old: {
      type: Array,
      default: null,
    },
    register_url: {
      type: String,
      default: '',
    },
    social_register_url: {
      type: String,
      default: '',
    },
    home_url: {
      type: String,
      default: '',
    },
  },
  data: function () {
    return {
      year: 0,
      month: 0,
      day: 0,
      first_name: '',
      last_name: '',
      email: '',
      email_confirmation: '',
      phone: '',
      password: '',
      errors: [],
      email_registered: false,
      marketing_opt_in: false,
      validationLoaded: false,
    }
  },
  computed: {
    years: function () {
      return _.range((new Date()).getFullYear(), 1927, -1)
    },
    lang () {
      return this.$store.state.lang
    },
    isSocialRegistration () {
      if (this.$store.getters.getUserType === 'incompleteProfile') {
        return true
      }
      return false
    },
    errorMessages () {
      return {
        firstName: this.lang.error_messages.first_name,
        lastName: this.lang.error_messages.last_name,
        email: this.lang.error_messages.email,
        emailConfirmation: this.lang.error_messages.email_confirmation,
        password: this.passwordErrorMessage,
        phoneNumber: this.lang.error_messages.phone_number,
        month: this.lang.error_messages.month,
        day: this.lang.error_messages.day,
        year: this.lang.error_messages.year,
      }
    },
    passwordErrorMessage () {
      if (this.password.length === 0) {
        return this.lang.error_messages.password[0]
      }

      return this.lang.error_messages.password[1]
    },
  },
  mounted: function () {
    this.hjTrigger('dash-registration')
    // load all tooltips
    $('[data-toggle="tooltip"]').tooltip()

    if (this.$store.getters.getUserType === 'incompleteProfile') {
      this.old = this.$store.state.User
    }
    const missingBirthday = this.old.year > 0 &&
            this.old.month > 0 &&
            this.old.day > 0
    const incompleteProfile = this.$store.getters.getUserType === 'incompleteProfile'
    if (missingBirthday || incompleteProfile) {
      this.year = Number(this.old.year)
      this.month = Number(this.old.month)
      this.day = Number(this.old.day)
      this.first_name = this.old.first_name
      this.last_name = this.old.last_name
      this.email = this.old.email
      this.email_confirmation = this.old.email_confirmation
      this.phone = this.old.phone
      this.marketing_opt_in = this.old.marketing_opt_in
    }

    var inputs = document.querySelectorAll('input')
    for (var i = 0; i < inputs.length; i++) {
      inputs[i].addEventListener('invalid', event => {
        this.validationError(event)
      }, false)
    }

    if (this.isSocialRegistration) {
      dataLayer.push({
        event: 'vpv',
        vpvUrl: '/virtual/createAccount/googleSignUpForm',
        vpvTitle: 'Registration Form – Google Signup Form',
      })
    } else {
      dataLayer.push({
        event: 'vpv',
        vpvUrl: '/virtual/createAccount/emailSignUpForm',
        vpvTitle: 'Registration Form -- Email Signup Form',
      })
    }
  },
  methods: {
    _verify (event) {
      if (this.year === 0 || this.month === 0 || this.day === 0) {
        if (event) event.preventDefault()
        this.year === 0 ? this.errors.year = true : this.errors.year = undefined
        this.month === 0 ? this.errors.month = true : this.errors.month = undefined
        this.day === 0 ? this.errors.day = true : this.errors.day = undefined
        this.$forceUpdate()
        return
      }

      var bd = new Date(this.year + 13, this.month - 1, this.day)
      if (bd >= (new Date())) {
        if (event) event.preventDefault()
        this.$emit('registration-error')
      } else {
        event.preventDefault()
        this.register()
      }
    },
    _validateEmail () {
      // prevent ajax if the email is blank and reset the form
      if (this.email === '') {
        this.reset_form()
        return
      }

      axios.post('/v3/api/register/email-address', { emailAddress: this.email })
        .then(response => {
          if (response.data.email_available === false) {
            this.email_registered = true
          } else if (this.email_registered === true && response.data.email_available === true) {
            this.reset_form()
          }
        })
        .catch(error => {
          // Lets fail back to the normal post validations if ajax gets an error
          this.reset_form(error)
        })
    },
    register: function () {
      const postUrl = this.isSocialRegistration ? this.social_register_url : this.register_url
      const postData = {
        csrf: this.csrf,
        year: this.year,
        month: this.month,
        day: this.day,
        first_name: this.first_name,
        last_name: this.last_name,
        phone: this.phone,
        is_social_registration: this.isSocialRegistration,
        teacher_registration_code: this.$parent.teacher_registration_code,
        marketing_opt_in: this.marketing_opt_in,
      }
      if (!this.isSocialRegistration) {
        postData.email = this.email
        postData.email_confirmation = this.email_confirmation
        postData.password = this.password
      }
      axios.post(postUrl, postData)
        .then(response => {
          if (response.status === 200) {
            if (this.$store.getters.getUserType === 'parent') {
              this.gaEvent('Titan Registration', 'Parent Registration', 'Started')
            } else {
              this.gaEvent('Titan Registration', 'Teacher Registration', 'Started')
            }

            if (this.isSocialRegistration) {
              dataLayer.push({
                event: 'vpv',
                vpvUrl: '/virtual/createAccount/googleSignUpComplete',
                vpvTitle: 'Registration Form – Google Signup Completed',
              })
            } else {
              dataLayer.push({
                event: 'vpv',
                vpvUrl: '/virtual/createAccount/emailSignUpComplete',
                vpvTitle: 'Registration Form – Email Signup Completed',
                acountType: capitalize(this.$store.getters.getUserType),
              })
            }

            this.$emit('registration-successful', response)
          } else {
            this.showErrors(response.errors)
          }
        })
        .catch(error => {
          this.showErrors(error.response)
        })
    },
    reset_form () {
      this.email_confirmation = ''
      this.email_registered = false
    },
    showErrors (errors) {
      this.errors = errors.data.errors
      console.error('show errors: Not Yet Implemented')
      console.error(errors)
    },
    maxNumberOfDays (month, year) {
      if (month === 2) {
        if ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0) {
          return 29
        } else {
          return 28
        }
      } else if (month === 4 || month === 6 || month === 9 || month === 11) {
        return 30
      }
      return 31
    },
    handleInputChange (e) {
      const name = e.target.getAttribute('name')
      if (name === 'month' || name === 'day' || name === 'year') {
        dataLayer.push({
          event: 'vpv',
          vpvUrl: 'vfields/createAccount/DoB$(name)}',
          vpvTitle: `Registration Form -- Date of Birth ${capitalize(name)} Field`,
        })
      } else if (name === 'email') {
        this.updateDataLayer(`${name}Field`)
        this._validateEmail()
      } else {
        this.updateDataLayer(`${name}Field`)
      }
    },
    updateDataLayer (field, title = null) {
      dataLayer.push({
        event: 'vpv',
        vpvUrl: `vfields/createAccount/${camelCase(field)}`,
        vpvTitle: title || `Registration Form -- ${startCase(field)}`,
      })
    },
    validationError (event) {
      if (!this.validationLoaded) {
        this.validationLoaded = true
        return
      }
      dataLayer.push({
        event: 'gaEvent',
        eventCategory: 'Account Creation Form Errors',
        eventAction: event.target.name,
        eventLabel: event.target.validationMessage,
      })
    },
  },

}
</script>
