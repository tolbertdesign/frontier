<template>
  <form
    novalidate
    role="form"
    class="px-3"
    @submit.prevent="submit"
  >
    <legend class="text-lg font-semibold mb-4">
      {{ lang.edit_profile.title }}
    </legend>
    <!-- First Name -->
    <BaseInput
      v-model.trim="form.first_name"
      :v="$v.form.first_name"
      :label="lang.edit_profile.first_name_label"
      :placeholder="lang.edit_profile.first_name_placeholder"
      required
    />

    <!-- Last Name -->
    <BaseInput
      v-model.trim="form.last_name"
      :v="$v.form.last_name"
      :label="lang.edit_profile.last_name_label"
      :placeholder="lang.edit_profile.last_name_placeholder"
      required
    />

    <!-- Email Address -->
    <BaseInput
      v-model.trim="form.email"
      :v="$v.form.email"
      :label="lang.edit_profile.email_label"
      :placeholder="lang.edit_profile.email_placeholder"
      :help-text="lang.edit_profile.email_help_text"
      type="email"
      required
    />

    <!-- Change Password Button -->
    <div class="field mb-4">
      <button
        class="inline-block my-4 py-1 px-2 underline font-normal text-secondary hover:text-black focus:outline-none rounded-lg focus:shadow-outline"
        @click.prevent="showChangePasswordModal()"
      >
        {{ lang.edit_profile.change_password }}
      </button>
    </div>

    <!-- Phone Number -->
    <BaseInput
      v-model="form.phone"
      :v="$v.form.phone"
      :label="lang.edit_profile.phone_label"
      :placeholder="lang.edit_profile.phone_placeholder"
      :help-text="lang.edit_profile.phone_help_text"
      type="tel"
      mask="(###) ###-####"
      required
    />

    <!-- Month, Day, Year-->
    <div class="field mb-4">
      <label
        for="birthday"
        class="inline-block mb-1 pl-2 text-grey-darker text-sm"
      >
        {{ lang.edit_profile.birthday_label }}
      </label>
      <div class="flex justify-between items-start -mx-2">
        <div class="w-1/3 mx-2">
          <div
            :class="{'is-danger border-red-600': $v.form.dob.$invalid}"
            class="select w-full"
          >
            <select
              v-model="birthMonth"
              class="w-full"
              required
            >
              <option disabled>
                {{ lang.edit_profile.month }}
              </option>
              <option
                v-for="month in months"
                :key="month.value"
                :value="month.value"
              >
                {{ month.label }}
              </option>
            </select>
          </div>
        </div>
        <div class="w-1/3 mx-2">
          <div
            :class="{'is-danger border-red-600': $v.form.dob.$invalid}"
            class="select w-full"
          >
            <select
              v-model="birthDay"
              class="w-full"
              required
            >
              <option disabled>
                {{ lang.edit_profile.day }}
              </option>
              <option
                v-for="i in maxNumberOfDays(birthMonth, birthYear)"
                :key="i"
                :value="padWithZero(i)"
              >{{ i }}</option>
            </select>
          </div>
        </div>
        <div class="w-1/3 mx-2">
          <div
            :class="{'is-danger border-red-600': $v.form.dob.$invalid}"
            class="select w-full"
          >
            <select
              v-model="birthYear"
              class="w-full"
            >
              <option disabled>
                {{ lang.edit_profile.year }}
              </option>
              <option
                v-for="i in years"
                :key="i"
                :value="i"
              >{{ i }}</option>
            </select>
          </div>
        </div>
      </div>
      <p
        v-if="$v.form.dob.$invalid"
        class="help is-danger pl-2 text-xs text-red-500"
      >
        {{ lang.edit_profile.minimum_age_error }}
      </p>
      <p
        v-if="!$v.form.dob.$invalid"
        class="help pl-2 text-xs"
      >
        {{ lang.edit_profile.dob_help_text }}
      </p>
    </div>

    <!-- Buttons -->
    <div class="text-center my-10 pb-10">
      <div class="max-w-md mx-0 md:mx-auto">
        <div class="flex flex-col items-center justify-center">
          <button
            :disabled="$v.$invalid"
            type="submit"
            class="inline-block w-full sm:w-64 mb-4 py-2 rounded-full leading-none text-lg font-semibold focus:outline-none focus:shadow-outline shadow-md bg-secondary text-white"
          >{{ lang.edit_profile.save }}</button>
          <RouterLink
            :to="{ name: 'parent-dashboard' }"
            tag="button"
            class="inline-block w-full sm:w-64 mb-4 py-2 rounded-full leading-none text-lg font-semibold focus:outline-none focus:shadow-outline shadow-md bg-white text-secondary hover:text-secondary-light border border-secondary hover:border-secondary-light"
          >{{ lang.edit_profile.cancel }}</RouterLink>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
import ChangePasswordModal from '@/components/pattern/ChangePasswordModal'
import SaveSuccessModal from '@/components/template/SaveSuccessModal'
import { range } from 'lodash'
import { required, email } from 'vuelidate/lib/validators'
import { notBooster, meetsMinimumAge, isPhone } from '@/utilities/customValidators'
import { mask } from 'vue-the-mask'

export default {
  name: 'EditProfileForm',
  status: 'prototype',
  release: '1.0.0',
  directives: { mask },
  props: {
    user: {
      type: Object,
      default: null,
    },
  },
  data () {
    return {
      test: null,
      focused: false,
      isLoading: false,
      hasError: false,
      form: {
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        dob: '0000-00-00',
      },
      months: [
        {
          value: '01',
          label: this.$store.state.lang.months.Jan,
        },
        {
          value: '02',
          label: this.$store.state.lang.months.Feb,
        },
        {
          value: '03',
          label: this.$store.state.lang.months.Mar,
        },
        {
          value: '04',
          label: this.$store.state.lang.months.Apr,
        },
        {
          value: '05',
          label: this.$store.state.lang.months.May,
        },
        {
          value: '06',
          label: this.$store.state.lang.months.Jun,
        },
        {
          value: '07',
          label: this.$store.state.lang.months.Jul,
        },
        {
          value: '08',
          label: this.$store.state.lang.months.Aug,
        },
        {
          value: '09',
          label: this.$store.state.lang.months.Sep,
        },
        {
          value: '10',
          label: this.$store.state.lang.months.Oct,
        },
        {
          value: '11',
          label: this.$store.state.lang.months.Nov,
        },
        {
          value: '12',
          label: this.$store.state.lang.months.Dec,
        },
      ],
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    years () {
      return range((new Date()).getFullYear(), 1927, -1)
    },
    birthDay: {
      get () {
        return this.form.dob.split('-')[2]
      },
      set (value) {
        const parts = this.form.dob.split('-')
        parts[2] = value
        const dob = parts.join('-')
        this.form = Object.assign({}, this.form, { dob })
      },
    },
    birthMonth: {
      get () {
        return this.form.dob.split('-')[1]
      },
      set (value) {
        const parts = this.form.dob.split('-')
        parts[1] = value
        const dob = parts.join('-')
        this.form = Object.assign({}, this.form, { dob })
      },
    },
    birthYear: {
      get () {
        return parseInt(this.form.dob.split('-')[0])
      },
      set (value) {
        const parts = this.form.dob.split('-')
        parts[0] = value
        const dob = parts.join('-')
        this.form = Object.assign({}, this.form, { dob })
      },
    },
    tooltipOptions () {
      return {
        classes: ['info'],
        content: this.lang.edit_profile.tooltip,
        placement: 'auto-start',
        trigger: 'hover click focus',
      }
    },
  },
  mounted () {
    const { first_name, last_name, email, dob, phone } = this.user
    this.form = { first_name, last_name, email, dob, phone }
  },
  validations: {
    form: {
      first_name: { required },
      last_name: { required },
      email: { required, email, notBooster },
      phone: { required, isPhone },
      dob: { required, meetsMinimumAge },
    },

  },
  methods: {
    padWithZero (day) {
      if (day < 10) {
        return `0${day}`
      }
      return day
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
    getSubmitData () {
      return {
        first_name: this.form.first_name,
        last_name: this.form.last_name,
        email: this.form.email,
        phone: this.form.phone,
        dob: this.form.dob,
      }
    },
    submit () {
      this.$v.$touch()
      this.$forceUpdate()

      if (this.$v.$invalid) return

      const submitData = this.getSubmitData()
      axios.post('/v3/parent/update', submitData)
        .then(response => {
          // this.user = Object.assign({}, this.user, this.form);
          this.$store.commit('UPDATE_USER', this.form)

          this.$buefy.modal.open({
            parent: this,
            component: SaveSuccessModal,
            scroll: 'keep',
            hasModalCard: true,
            canCancel: false,
            props: {
              title: this.lang.edit_profile.saved_successfully,
            },
          })
        })
    },
    showChangePasswordModal () {
      this.addClass(document.querySelector('body'), 'modal-is-open')

      this.$buefy.modal.open({
        parent: this,
        component: ChangePasswordModal,
        hasModalCard: true,
        canCancel: ['escape', 'outside'],
        onCancel: () => {
          this.removeClass(document.querySelector('body'), 'modal-is-open')
        },
      })
    },
    addClass (element, className) {
      element.classList.add(className)
    },
    removeClass (element, className) {
      element.classList.remove(className)
    },
  },
}
</script>
