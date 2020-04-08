import { shallowMount } from '@vue/test-utils'
import ParentDashboardLayout from './ParentDashboardLayout.vue'

describe('ParentDashboardLayout', () => {
  const program = {
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

  const $storeBannerKilled = {
    state: {
      lang: {
        beta_banner_return: 'Back to TK',
      },
      beta_banner_kill_switch: true,
    },
  }

  const $storeBannerShows = {
    state: {
      lang: {
        beta_banner_return: 'Back to TK',
      },
      beta_banner_kill_switch: false,
    },
    gtag: jest.fn(),
  }

  it('matches snapshot', () => {
    const wrapper = shallowMount(ParentDashboardLayout, {
      mocks: { $store: $storeBannerKilled },
      propsData: { program: program },
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('matches snapshot', () => {
    const wrapper = shallowMount(ParentDashboardLayout, {
      mocks: { $store: $storeBannerShows },
      propsData: { program: program },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
