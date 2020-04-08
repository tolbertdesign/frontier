import { shallowMount } from '@vue/test-utils'
import PledgeInfo from './PledgeInfo.vue'

describe('PledgeInfo', () => {
  const programWithOnePledge = {
    participants: [
      {
        participant_info: {
          pledges: [
            {
              id: 1,
            },
          ],
        },
      },
    ],
  }

  const programWithManyPledges = {
    participants: [
      {
        participant_info: {
          pledges: [
            {
              id: 1,
            },
            {
              id: 2,
            },
          ],
        },
      },
    ],
  }

  const $store = {
    state: {
      lang: {
        pledge_info: {},
      },
    },
  }

  it('matches snapshot with 1 pledge', () => {
    const wrapper = shallowMount(PledgeInfo, {
      mocks: { $store },
      propsData: { program: programWithOnePledge },
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('matches snapshot with multiple pledges', () => {
    const wrapper = shallowMount(PledgeInfo, {
      mocks: { $store },
      propsData: { program: programWithManyPledges },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
