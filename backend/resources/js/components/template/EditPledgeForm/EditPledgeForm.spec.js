import { shallowMount, createLocalVue } from '@vue/test-utils'
import EditPledgeForm from './EditPledgeForm.vue'
import Vuex from 'vuex'
import Vuelidate from 'vuelidate'
import { STATUS_ENTERED, STATUS_CONFIRMED, STATUS_PAID } from '@/store/modules/pledge.js'
import { STATUS_PENDING, STATUS_DENIED } from '@/store/modules/online_pending_payment.js'
import VTooltip from 'v-tooltip'

const localVue = createLocalVue()
localVue.use(Vuex)
localVue.use(Vuelidate)
localVue.use(VTooltip)

describe('EditPledgeForm', () => {
  const PPU = 1
  const FLAT = 3
  const program = {
    unit_range_low: 30,
    unit_range_high: 35,
  }

  let pledgeData = {}
  let store
  let storeProps

  beforeEach(() => {
    pledgeData = []
    storeProps = {
      lang: {
        pledge_edit: {},
      },
      User: {
        id: 1,
      },
    }
    store = new Vuex.Store({
      state: storeProps,
    })
  })

  it('correctly reads if can edit amount when pledge is paid', done => {
    addPledge()
    pledgeData[0].pledge_status_id = STATUS_PAID
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.canEditAmount()).toBe(false)
    done()
  })

  it('correctly reads if can edit amount when pledge is confirmed (no laps)', done => {
    addPledge()
    pledgeData[0].pledge_status_id = STATUS_CONFIRMED
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.canEditAmount()).toBe(true)
    done()
  })

  it('correctly reads if can edit amount when pledge is confirmed (has laps)', done => {
    addPledge()
    pledgeData[0].pledge_status_id = STATUS_CONFIRMED
    pledgeData[0].participant.laps = 1
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.canEditAmount()).toBe(false)
    done()
  })

  it('correctly reads if can edit amount when non sponsor\'s pledge is just entered', done => {
    store.state.User.id = 2
    addPledge()
    pledgeData[0].pledge_status_id = STATUS_ENTERED
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.canEditAmount()).toBe(true)
    done()
  })

  it('correctly reads if can edit amount when non sponsor\'s pledge is just entered w/ pending payments', done => {
    store.state.User.id = 2
    addPledge()
    pledgeData[0].pledge_status_id = STATUS_ENTERED
    pledgeData[0].online_pending_payments = [
      {
        online_pending_payment_status_id: STATUS_PENDING,
      },
    ]
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.canEditAmount()).toBe(false)
    done()
  })

  it('correctly reads if can edit amount when non sponsor\'s pledge is just entered w/ non pending payments', done => {
    store.state.User.id = 2
    addPledge()
    pledgeData[0].pledge_status_id = STATUS_ENTERED
    pledgeData[0].online_pending_payments = [
      {
        online_pending_payment_status_id: STATUS_DENIED,
      },
    ]
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.canEditAmount()).toBe(true)
    done()
  })

  it('matches snapshot with 1 pledge', () => {
    addPledge(3)
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('does not disable states when US is selected', () => {
    addPledge()
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })
    expect(wrapper.find('#state').attributes('disabled')).toBe(undefined)
  })

  it('disables state on country change', () => {
    addPledge()
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })
    wrapper.find('#country').element.value = 'CA'
    wrapper.find('#country').trigger('change')
    expect(wrapper.find('#state').attributes('disabled')).toBe('disabled')
  })

  it('disables states when US is not selected', () => {
    addPledge()
    pledgeData[0].pledge_sponsor.country = 'UK'
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })
    expect(wrapper.find('#state').attributes('disabled')).toBe('disabled')
  })

  it('sets the proper fields', () => {
    addPledge(3)
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })
    expect(wrapper.vm.pledge.first_name).toBe(pledgeData[0].first_name)
    expect(wrapper.find('#sponsorFirstName').element.value).toBe(pledgeData[0].pledge_sponsor.first_name)
    expect(wrapper.find('#sponsorLastName').element.value).toBe(pledgeData[0].pledge_sponsor.last_name)
    expect(wrapper.find('#sponsorEmail').element.value).toBe(pledgeData[0].pledge_sponsor.email)
    expect(parseFloat(wrapper.find('#pledgeAmount').element.value)).toBe(pledgeData[0].amount)
  })

  it('matches snapshot with multiple pledges', () => {
    addPledge(3, FLAT)
    addPledge(3, FLAT)
    addPledge(3, FLAT)
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },

    })
    expect(wrapper).toMatchSnapshot()
  })

  it('calculates total for ppu pledge with decimal', done => {
    addPledge(3.01, PPU)
    addPledge(3.01, PPU)
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.estimatedTotal).toBe('$180.60 - $210.70')
    done()
  })

  it('calculates total for flat pledge with decimal', done => {
    addPledge(3.21, FLAT)
    addPledge(3.21, FLAT)
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.estimatedTotal).toBe('$6.42')
    done()
  })

  it('calculates total for ppu pledge', done => {
    addPledge(3, PPU)
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.estimatedTotal).toBe('$90 - $105')
    done()
  })

  it('calculates total for ppu pledge with laps', done => {
    addPledge(3, PPU, 20)
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.estimatedTotal).toBe('$60')
    done()
  })

  it('calculates total for multiple ppu pledge', done => {
    addPledge(3, PPU)
    addPledge(3, PPU)
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.estimatedTotal).toBe('$180 - $210')
    done()
  })

  it('calculates total for flat pledge', done => {
    addPledge(3, FLAT)
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.estimatedTotal).toBe('$3')
    done()
  })

  it('calculates total for multiple flat pledge', done => {
    addPledge(3, FLAT)
    addPledge(3, FLAT)
    const wrapper = shallowMount(EditPledgeForm, {
      localVue,
      store,
      propsData: { pledgeData, program },
    })

    expect(wrapper.vm.estimatedTotal).toBe('$6')
    done()
  })

  const addPledge = (amount, type, laps) => {
    pledgeData.push(
      {
        amount: amount,
        sponsor_type_id: 2,
        pledge_type_id: type,
        online_pending_payments: [],
        pledge_sponsor: {
          first_name: 'Ronald',
          last_name: 'Johnson',
          email: 'ronald.johnson@gmail.com1',
          phone_number: 7707707777,
          city: 'St. Louis',
          state: 'MO',
          country: 'US',
        },
        participant: {
          laps: laps,
        },
      },
    )
  }
})
