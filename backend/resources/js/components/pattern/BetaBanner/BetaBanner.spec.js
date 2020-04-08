import { shallowMount } from '@vue/test-utils'
import BetaBanner from './BetaBanner.vue'

describe('BetaBanner', () => {
  it('is a Vue instance', () => {
    const $store = {
      state: {
        lang: {
          beta_banner_return: 'Return',
        },
      },
    }

    const wrapper = shallowMount(BetaBanner, {
      mocks: { $store },
    })

    expect(wrapper.isVueInstance()).toBeTruthy()
    expect(wrapper).toMatchSnapshot()
  })
})
