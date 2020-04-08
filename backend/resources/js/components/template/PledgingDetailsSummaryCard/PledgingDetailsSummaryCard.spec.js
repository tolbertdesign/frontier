import { shallowMount, createLocalVue } from '@vue/test-utils'
import PledgingDetailsSummaryCard from './PledgingDetailsSummaryCard'
import Vuex from 'vuex'
import { VTooltip } from 'v-tooltip'
import LanguageParser from '@/mixins/LanguageParser'
import axonMock from '@/axon/mocks.js'

const localVue = createLocalVue()
localVue.use(Vuex)
localVue.use(VTooltip)
localVue.directive('tooltip', VTooltip)
localVue.mixin(LanguageParser)

describe('PledgingDetailsSummaryCard', () => {
  const $store = {
    state: {
      lang: {
        finish_line: 'Finish Line',
        total_pledged_amount: 'Total Pledged Amount',
        total_payments_received: 'Total Payments Received',
        outstanding_pledges_due: 'Outstanding Pledges Due',
        view_pledging_details: 'View Pledge Details',
        close_pledging_details: 'Close Pledge Details',
        units_completed: 'Laps Completed',
        flat_donations: 'Flat Donations',
        pledging: 'Pledging',
        payment_scheduled_online: 'Payment Scheduled Online',
        paid_online: 'Paid Online',
        checks_and_cash_deposits: 'Checks and All Cash Deposits',
        outstanding: 'Outstanding',
        update_units_success_title: ':name_plural updated!',
        update_units_success_subtitle: 'If a payment has already been processed based on the incorrect :name_plural completed, please contact our Help Desk.',
        finish_line_other_payment_options: 'You can also pay by sending a check or cash to your school with your student by <b>:due_date</b>. Checks made payable to the <b>school</b>.',
      },
    },
    getters: {
      avatarPath: 'globalAvatarPath',
    },
    gtag: jest.fn(),
  }
  it('is a Vue instance', () => {
    const wrapper = shallowMount(
      PledgingDetailsSummaryCard,
      {
        localVue,
        mocks: { $store },
      },
    )
    expect(wrapper.isVueInstance()).toBeTruthy()
  })
  it('calculates flat total for a participant', () => {
    const pledges = [
      {
        amount: 13.02,
        pledge_type_id: 3,
      },
      {
        amount: 10.02,
        pledge_type_id: 3,
      },
      {
        amount: 13.02,
        pledge_type_id: 1,
      },
    ]
    const wrapper = shallowMount(
      PledgingDetailsSummaryCard,
      {
        localVue,
        mocks: { $store },
      },
    )
    expect(wrapper.vm.flatDonations(pledges)).toBe(23.04)
  })
  it('calculates ppu total for a participant', () => {
    const laps = 11
    const pledges = [
      {
        amount: 13.02,
        pledge_type_id: 3,
      },
      {
        amount: 10.02,
        pledge_type_id: 3,
      },
      {
        amount: 0.02,
        pledge_type_id: 1,
      },
      {
        amount: 1,
        pledge_type_id: 1,
      },
    ]
    const wrapper = shallowMount(
      PledgingDetailsSummaryCard,
      {
        localVue,
        mocks: { $store },
      },
    )
    expect(wrapper.vm.ppuDonations(pledges, laps)).toBe(11.22)
  })
  it('calculates total pledging for a participant', () => {
    const laps = 11
    const pledges = [
      {
        amount: 13.02,
        pledge_type_id: 3,
      },
      {
        amount: 10.02,
        pledge_type_id: 3,
      },
      {
        amount: 0.02,
        pledge_type_id: 1,
      },
      {
        amount: 1,
        pledge_type_id: 1,
      },
    ]
    const wrapper = shallowMount(
      PledgingDetailsSummaryCard,
      {
        localVue,
        mocks: { $store },
      },
    )
    expect(wrapper.vm.pledgingTotal(pledges, laps)).toBe(34.26)
  })
  it('calculates payment scheduled for a participant', () => {
    const participant = {
      laps: 11,
      participant_info: {
        pledges: [
          {
            amount: 13.02,
            pledge_type_id: 3,
            pledge_status_id: 8,
          },
          {
            amount: 10.02,
            pledge_type_id: 3,
          },
          {
            amount: 0.02,
            pledge_type_id: 1,
            pledge_status_id: 8,
          },
          {
            amount: 1,
            pledge_type_id: 1,
          },
        ],
      },
    }
    const wrapper = shallowMount(
      PledgingDetailsSummaryCard,
      {
        localVue,
        mocks: { $store },
      },
    )
    expect(wrapper.vm.paymentScheduledOnline(participant)).toBe(13.24)
  })
  it('calculates paid online for a participant', () => {
    const participant = {
      laps: 11,
      participant_info: {
        pledges: [
          {
            amount: 13.02,
            pledge_type_id: 3,
            pledge_status_id: 8,
          },
          {
            amount: 10.02,
            pledge_type_id: 3,
            pledge_status_id: 3,
          },
          {
            amount: 0.02,
            pledge_type_id: 1,
            pledge_status_id: 8,
          },
          {
            amount: 1,
            pledge_type_id: 1,
            pledge_status_id: 3,
          },
        ],
      },
    }
    const wrapper = shallowMount(
      PledgingDetailsSummaryCard,
      {
        localVue,
        mocks: { $store },
      },
    )
    expect(wrapper.vm.paidOnline(participant)).toBe(21.02)
  })
  it('renders participant details summary card snapshot', () => {
    const participants = [
      {
        first_name: 'john',
        laps: 32,
        profile: {
          image_name: 'profileimage.png',
        },
        participant_info: {
          pledges: [
            {
              amount: 1,
              pledge_type_id: 3,
              pledge_status_id: 8,
            },
            {
              amount: 1,
              pledge_type_id: 3,
              pledge_status_id: 8,
            },
          ],
        },
      },
    ]
    const unit = {
      modifier: 'per',
      name: 'lap',
    }
    const wrapper = shallowMount(PledgingDetailsSummaryCard, {
      localVue,
      mocks: {
        $store,
        $axon: axonMock,
      },
      propsData: {
        participants,
        unit,
        noUnitsEnteredDefault: 30,
      },
    })
    wrapper.setData({ isOpen: true })
    expect(wrapper).toMatchSnapshot()
  })

  it('renders participant details summary card snapshot', () => {
    const participants = [
      {
        first_name: 'jane',
        laps: 33,
        profile: {
          image_name: 'profileimage2.png',
        },
        participant_info: {
          pledges: [],
        },
      },
    ]
    const unit = {
      modifier: 'per',
      name: 'lap',
    }
    const wrapper = shallowMount(PledgingDetailsSummaryCard, {
      localVue,
      mocks: {
        $store,
        $axon: axonMock,
      },
      propsData: {
        participants,
        unit,
        noUnitsEnteredDefault: 30,
      },
    })
    wrapper.setData({ isOpen: true })
    expect(wrapper).toMatchSnapshot()
  })
})
