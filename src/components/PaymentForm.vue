<template>
  <div class="payment-form card-body">
    <form
      :novalidate="!isIE11"
      role="form"
      @keydown.enter.prevent
      @submit.prevent="_submit"
    >
      <legend class="h4 font-weight-bold text-center">
        {{ lang.student_title }}
      </legend>

      <!-- <transition-group name="slide-fade">

      </transition-group> -->
      <div
        v-for="(student, index) in $v.form.students.$each.$iter"
        :key="index"
        class="student"
      >
        <div class="form-group">
          <div
            v-if="student.isDuplicate.$model"
            class="has-error font-weight-bold"
            v-html="lang.no_duplicate_students"
          />
          <label class="sr-only" for="student_first_name">{{
            lang.student_first_name
          }}</label>
          <input
            v-model.trim="student.first_name.$model"
            :placeholder="lang.student_first_name"
            :class="{
              'is-invalid':
                student.first_name.$error || student.isDuplicate.$model,
            }"
            :name="`student_first_name[${index}]`"
            type="text"
            class="form-control"
            required
          >
        </div>
        <div class="form-group">
          <label class="sr-only" for="student_last_name">{{
            lang.student_last_name
          }}</label>
          <input
            v-model.trim="student.last_name.$model"
            :placeholder="lang.student_last_name"
            :class="{
              'is-invalid':
                student.last_name.$error || student.isDuplicate.$model,
            }"
            :name="`student_last_name[${index}]`"
            type="text"
            class="form-control"
            required
          >
        </div>
        <div class="form-group clearfix">
          <select
            v-model.trim="student.classroom_id.$model"
            :class="{
              'is-invalid':
                student.classroom_id.$error || student.isDuplicate.$model,
            }"
            :name="`classroom_id[${index}]`"
            class="form-control"
            placeholder="lang.classroom"
            required
          >
            <option :value="null" disabled>
              {{ lang.classroom }}
            </option>
            <option
              v-for="classroom in program.classrooms"
              :key="classroom.id"
              :value="classroom.id"
            >{{ classroom.name }}</option>
          </select>
          <button
            v-if="index > 0 && index === form.students.length - 1"
            type="button"
            class="btn btn-link float-right"
            @click.prevent="removeStudent"
          >
            {{ lang.student_remove_title }}
            <i class="far fa-trash" />
          </button>
        </div>
        <hr v-if="index !== form.students.length - 1">
      </div>
      <div class="form-group mt-4 mb-5">
        <button
          class="btn btn-sm btn-primary btn-rounded px-25"
          @click.prevent="addStudent"
        >
          {{ lang.student_add_title }}
        </button>
      </div>

      <legend class="h4 font-weight-bold mb-4 text-center">
        {{ lang.store_credit_title }}
      </legend>

      <div class="form-group">
        <div class="btn-group d-flex justify-content-around" role="group">
          <div v-for="(item, index) in preSelectOptions" :key="index">
            <button
              :ref="`button${index}`"
              :value="item.amount"
              :class="{ 'is-selected': item.isSelected }"
              type="button"
              class="btn btn-circle btn-secondary"
              @click="preSelect(item)"
            >
              ${{ item.amount }}
            </button>
            <p>Per Student</p>
          </div>
        </div>
      </div>

      <div class="form-group mb-5 font-weight-bold">
        <label class="mb-10px">{{ lang.store_credit_amount }}</label>
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <div class="input-group-text">
              $
            </div>
          </div>
          <input
            :value="otherAmount"
            :class="[
              { 'is-invalid': $v.form.amount.$error && focused === false },
              'py-10px',
            ]"
            :placeholder="lang.store_credit_amount_placeholder"
            class="form-control form-control-lg text-center is-standard"
            @keypress="isNumber"
            @focus="focused = true && $event.target.select()"
            @blur="focused = false"
            @input="_moneyChanged"
          >
        </div>
        <div
          v-if="$v.form.amount.$error && focused === false"
          class="has-error"
        >
          {{ lang.minimum_amount_error }}
        </div>
      </div>

      <legend class="h4 font-weight-bold text-center">
        {{ lang.payment_information }}
      </legend>
      <div class="form-group">
        <label class="sr-only">{{ lang.payer_first_name }}</label>
        <input
          v-model="form.payer.first_name"
          :class="{ 'is-invalid': $v.form.payer.first_name.$error }"
          type="text"
          class="form-control"
          placeholder="First name"
          required
          dusk="payer_first_name"
        >
      </div>
      <div class="form-group">
        <label class="sr-only">{{ lang.payer_last_name }}</label>
        <input
          v-model="form.payer.last_name"
          :class="{ 'is-invalid': $v.form.payer.last_name.$error }"
          type="text"
          class="form-control"
          placeholder="Last name"
          required
          dusk="payer_last_name"
        >
      </div>
      <div class="form-group">
        <label class="sr-only">{{ lang.payer_email }}</label>
        <input
          v-model="form.payer.email"
          :class="{ 'is-invalid': $v.form.payer.email.$error }"
          type="email"
          name="email"
          class="form-control"
          placeholder="Email"
          required
          dusk="payer_email"
        >
      </div>

      <cc-form :error="cardError" />
      <transition name="slide-fade">
        <div
          v-if="$v.form.students.$model[0].first_name"
          class="p-2 rounded mb-4 bg-white"
        >
          <table class="table table-sm mb-0">
            <tr
              v-for="(student, index) in $v.form.students.$each.$iter"
              :key="index"
            >
              <td class="text-left w-100">
                {{ student.first_name.$model }}
              </td>
              <td class="text-right font-weight-light text-nowrap">
                {{ lang.store_credit }}
              </td>
              <td class="text-right text-nowrap">
                ${{ formatPrice($v.form.amount.$model) }}
              </td>
            </tr>
            <tr v-if="program.sponsor_convenience_fee > 0">
              <td class="text-left font-weight-light w-100" colspan="2">
                {{ lang.online_processing_fee }}
              </td>
              <td class="text-right text-nowrap">
                ${{ formatPrice(program.sponsor_convenience_fee) }}
              </td>
            </tr>
          </table>
        </div>
      </transition>

      <transition name="slide-fade">
        <h4
          v-if="$v.form.students.$model[0].first_name"
          class="text-center font-weight-bold"
        >
          {{ lang.total }}: $ {{ formatPrice(total) }}
        </h4>
      </transition>

      <button
        :disabled="payPending"
        class="btn btn-rounded btn-primary btn-block mb-3"
        dusk="submit-button"
      >
        {{ lang.submit_btn }}
        <i v-if="payPending" class="fa fa-spinner fa-spin" />
      </button>

      <a
        class="text-inherit"
        data-toggle="modal"
        data-target="#paymentTermsModal"
        href="#"
      >
        <u>{{ lang.terms_title }}</u>
      </a>
    </form>
  </div>
</template>

<script>
import { required, minValue, email } from 'vuelidate/lib/validators'
import { client, hostedFields } from 'braintree-web'
import CreditCardForm from '@/components/CreditCardForm'

var isIE =
  '-ms-scroll-limit' in document.documentElement.style &&
  '-ms-ime-align' in document.documentElement.style
var isEdge =
  '-ms-scroll-limit' in document.documentElement.style &&
  '-ms-ime-align' in document.documentElement.style &&
  !window.navigator.msPointerEnabled

export default {
  components: { CreditCardForm },
  props: {
    setLang: {
      type: Object,
      default: null,
    },
    program: {
      type: Object,
      default: null,
    },
    preSelectAmountOptions: {
      type: Object,
      default: null,
    },
    relationships: {
      type: Array,
      default: null,
    },
    braintreeMerchantId: {
      type: String,
      default: null,
    },
    paymentUrl: {
      type: String,
      default: null,
    },
    receiptUrl: {
      type: String,
      default: null,
    },
  },
  data () {
    return {
      hasDuplicateStudents: false,
      testFlat: 'flat_a',
      form: {
        students: [
          {
            first_name: null,
            last_name: null,
            classroom_id: null,
            isDuplicate: false,
          },
        ],
        payer: {
          first_name: null,
          last_name: null,
          email: null,
        },
        amount: null,
      },
      otherAmount: null,
      money: {
        masked: false,
      },
      payPending: false,
      cardError: {
        code: '',
        message: '',
        details: {
          invalidFieldKeys: [],
        },
      },
      formInstance: null,
      amountDirty: false,
      focused: false,
      isIE11: isIE && !isEdge,
    }
  },
  computed: {
    lang () {
      return this.$store.state.lang
    },
    total () {
      return (
        this.form.amount * this.form.students.length +
        parseFloat(this.program.sponsor_convenience_fee)
      )
    },
    full_name () {
      return this.form.payer.first_name + ' ' + this.form.payer.last_name
    },
    preSelectOptions () {
      return this.preSelectAmountOptions[this.testFlat]
        .map((option, index) => {
          return {
            isSelected: index === 0,
            amount: parseInt(option),
          }
        })
        .slice(0, 3)
    },
  },
  mounted () {
    this.isIE11 && setTimeout(() => $(this.$refs.button0).click(), 200)
    this.$store.commit('SET_LANG', this.setLang)
    this.preSelect(this.preSelectOptions[0])
    this.mountCreditCard()
  },
  validations: {
    form: {
      students: {
        required,
        $each: {
          first_name: {
            required,
          },
          last_name: {
            required,
          },
          classroom_id: {
            required,
          },
          isDuplicate: {
            required,
          },
        },
      },
      amount: {
        minValue: minValue(5),
      },
      payer: {
        first_name: {
          required,
        },
        last_name: {
          required,
        },
        email: {
          required,
          email,
        },
      },
    },
  },
  methods: {
    addStudent () {
      this.form.students.push({
        first_name: null,
        last_name: null,
        classroom_id: null,
      })
    },
    removeStudent () {
      this.form.students.pop()
    },
    formatPrice (value) {
      const val = (value / 1).toFixed(2).replace(',', '.')
      return val
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
        .replace('.00', '')
    },
    validateDuplicateStudents () {
      const roomStudents = this.form.students.map(s => {
        return ('' + s.classroom_id + s.first_name + s.last_name).toLowerCase()
      })
      const roomStudentsSet = new Set(roomStudents)
      this.hasDuplicateStudents = roomStudentsSet.size !== roomStudents.length
      roomStudents.forEach((student, index) => {
        this.form.students[index].isDuplicate = !roomStudentsSet.delete(
          student,
        )
      })
    },
    _submit (event) {
      this.validateDuplicateStudents()
      this.amountDirty = true
      this.$v.$touch()
      this.$forceUpdate()
      if (this.$v.$invalid || this.hasDuplicateStudents) {
        document.body.scrollTop = 0
      } else {
        this.cardError = {
          code: '',
          message: '',
          details: {
            invalidFieldKeys: [],
          },
        }
        this.validateCreditCard()
      }
    },
    mountCreditCard () {
      client
        .create({
          authorization: this.braintree_merchant_id,
        })
        .then(clientInstance => {
          var options = {
            client: clientInstance,
            styles: {
              input: {
                'font-size': '0.9rem',
                color: '#495057',
              },
            },
            fields: {
              number: {
                selector: '#card-number',
                placeholder: 'Card number',
              },
              cvv: {
                selector: '#cvv',
                placeholder: 'CVV',
              },
              expirationDate: {
                selector: '#expiration-date',
                placeholder: 'Exp. MM/YYYY',
              },
            },
          }
          hostedFields
            .create(options)
            .then(fieldInstance => {
              this.formInstance = fieldInstance
            })
            .catch(error => {
              console.error(error)
            })
        })
    },
    validateCreditCard () {
      if (this.payPending === false) {
        this.payPending = true
        this.formInstance
          .tokenize({
            cardholderName: this.full_name,
          })
          .then(response => {
            this.submit_payment(response.nonce)
          })
          .catch(error => {
            console.error(error)
            this.cardError = {
              code: error.code || '',
              message: this.lang.errors[error.code] || '',
              details: error.details || {},
            }
            this.payPending = false
          })
      }
    },
    submit_payment (nonce) {
      axios
        .post(this.payment_url, { form: this.form, nonce })
        .then(response => {
          this.cardError = null
          window.location.href = '/receipt/' + this.program.id
        })
        .catch(error => {
          this.cardError = {
            code: error.code || '',
            message:
              this.lang.errors[error.response.data.error] ||
              this.lang.errors.payment_error,
            details:
              error.response.data.error.message === 'Gateway Rejected: cvv'
                ? { invalidFieldKeys: ['cvv'] }
                : { invalidFieldKeys: ['number', 'expirationDate', 'cvv'] },
          }
          this.payPending = false
        })
    },
    isNumber (e) {
      e = e || window.event
      var charCode = e.which ? e.which : e.keyCode
      if (
        charCode > 31 &&
        (charCode < 48 || charCode > 57) &&
        charCode !== 46
      ) {
        e.preventDefault()
      } else {
        return true
      }
    },
    deselectPreSelectOptions () {
      this.preSelectOptions.forEach(option => {
        option.isSelected = false
      })
    },
    preSelect (item) {
      this.deselectPreSelectOptions()
      this.otherAmount = null
      this.$v.form.amount.$model = item.amount
      item.isSelected = true
    },
    _moneyChanged (event) {
      this.deselectPreSelectOptions()
      this.otherAmount = event.target.value
      this.$v.form.amount.$model = event.target.value
      if (event >= 1) {
        this.amountDirty = true
      }
    },
  },
}
</script>

<style lang="scss">
.payment-form {
  tr:first-child td {
    border-top: none;
  }
}
.has-error {
  color: red;
}
.slide-fade-enter-active {
  transition: all 0.5s ease-in-out;
}
.slide-fade-leave-active {
  transition: all 0.5s ease-in-out;
}
.slide-fade-enter,
.slide-fade-leave-to {
  transform: translateY(-10px);
  opacity: 0;
}
</style>
