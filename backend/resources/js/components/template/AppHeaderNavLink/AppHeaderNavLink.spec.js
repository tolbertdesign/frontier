import { shallowMount, createLocalVue } from '@vue/test-utils'
import AppHeaderNavLink from './AppHeaderNavLink.vue'

const localVue = createLocalVue()

describe('AppHeaderNavLink', () => {
  it('Snapshop test for AppHeaderNavLink', () => {
    const wrapper = shallowMount(AppHeaderNavLink, {
      localVue,
      slots: {
        default: '<div class="slot"></div>',
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
