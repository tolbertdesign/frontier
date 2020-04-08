import { shallowMount } from '@vue/test-utils'
import PledgeInfoCard from './PledgeInfoCard.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

describe('PledgeInfoCard', () => {
  const program = {
    unit_range_low: 30,
    unit_range_high: 35,
    program_pledge_setting: {
      family_pledging_enabled: 1,
    },
  }

  const pledges = [
    {
      pledge_status_id: 1,
      amount: 5.31,
      pledge_sponsor: {
        first_name: 'Test',
        last_name: 'Test',
      },
      participant: {
        first_name: 'Student1',
        participant_info: { family_pledging_enabled: 1 },
      },
    },
  ]

  const $store = {
    getters: {
      familyPledges: (pledges) => [
        {
          pledge_status_id: 1,
          amount: 5.31,
          pledge_sponsor: {
            first_name: 'Test',
            last_name: 'Test',
          },
          participant: {
            first_name: 'Student1',
            participant_info: { family_pledging_enabled: 1 },
          },
        },
      ],
    },
    state: {
      lang: {
        pledges: {
          months: [],
        },
        pledge_info: {},
        statuses: {
          1: 'entered',
          2: '',
          3: 'paid',
          4: 'awaiting confirmation',
          5: 'deleted',
          6: 'cancelled',
          7: 'abandoned',
          8: 'payment scheduled',
        },
      },
    },
  }

  it('matches snapshot of pledge info card', () => {
    const wrapper = shallowMount(PledgeInfoCard, {
      mocks: { $store },
      components: {
        FontAwesomeIcon,
      },
      propsData: {
        pledges: pledges,
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
