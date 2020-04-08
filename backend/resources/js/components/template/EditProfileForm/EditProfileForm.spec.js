import { shallowMount, createLocalVue } from '@vue/test-utils'
import EditProfileForm from './EditProfileForm.vue'
import Vuelidate from 'vuelidate'
import { VTooltip } from 'v-tooltip'

const localVue = createLocalVue()
localVue.use(Vuelidate)
const BaseInput = require('../../element/BaseInput')
localVue.component('BaseInput', BaseInput)
localVue.component('FontAwesomeIcon', require('../../../plugins/fontawesome'))
localVue.component('RouterLink', require())
localVue.directive('tooltip', VTooltip)

describe('EditProfileForm', () => {
  const user = {
    first_name: 'john',
    last_name: 'smith',
    email: 'john@smith.com',
    phone: '5555555555',
    dob: '1900-01-01',
  }

  const $store = {
    state: {
      lang: {
        pledge_info: {},
        edit_profile: {
          tooltip: 'great tooltip',
          minimum_age_error: 'DOB ERROR MESSAGE',
        },
        months: {
          Jan: 'Jan',
          Feb: 'Feb',
          Mar: 'Mar',
          Apr: 'Apr',
          May: 'May',
          Jun: 'Jun',
          Jul: 'Jul',
          Aug: 'Aug',
          Sep: 'Sep',
          Oct: 'Oct',
          Nov: 'Nov',
          Dec: 'Dec',
        },
      },
    },
  }

  const $v = {
    form: {
      first_name: '',
      last_name: '',
      dob: {
        $invalid: false,
      },
    },
  }

  const $vInvalid = {
    form: {
      first_name: {
        $invalid: true,
      },
      last_name: {
        $invalid: true,
      },
      dob: {
        $invalid: true,
      },
      phone: {
        $invalid: true,
      },
      email: {
        $invalid: true,
      },
    },
  }

  it('renders edit profile form', () => {
    const wrapper = shallowMount(EditProfileForm, {
      mocks: { $store, $v },
      propsData: { user },
      localVue,
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('is a Vue instance', () => {
    const wrapper = shallowMount(EditProfileForm, {
      mocks: { $store },
      propsData: { user },
      localVue,
    })
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  it('calculates max number of days in no month', () => {
    const wrapper = shallowMount(EditProfileForm, {
      mocks: { $store },
      propsData: { user },
      localVue,
    })
    expect(wrapper.vm.maxNumberOfDays()).toBe(31)
  })

  it('calculates max number of days in April', () => {
    const wrapper = shallowMount(EditProfileForm, {
      mocks: { $store },
      propsData: { user },
      localVue,
    })
    expect(wrapper.vm.maxNumberOfDays(4, 1990)).toBe(30)
  })

  it('gathers correct data to submit', () => {
    const wrapper = shallowMount(EditProfileForm, {
      mocks: { $store },
      propsData: { user },
      localVue,
    })
    expect(wrapper.vm.getSubmitData()).toStrictEqual({
      first_name: 'john',
      last_name: 'smith',
      email: 'john@smith.com',
      phone: '5555555555',
      dob: '1900-01-01',
    })
  })

  it('displays error message when dob is invalid', () => {
    const wrapper = shallowMount(EditProfileForm, {
      mocks: { $store, $v: $vInvalid },
      propsData: { user },
      localVue,
    })
    expect(wrapper.text()).toContain('DOB ERROR MESSAGE')
  })
})
