import { shallowMount, createLocalVue } from '@vue/test-utils'
import AppHeaderNavSection from './AppHeaderNavSection.vue'

const localVue = createLocalVue()

describe('AppHeaderNavSection', () => {
  it('Snapshop test for AppHeaderNavSection', () => {
    const wrapper = shallowMount(AppHeaderNavSection, {
      localVue,
      slots: {
        default: '<div class="slot"></div>',
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
