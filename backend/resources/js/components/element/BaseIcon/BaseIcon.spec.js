import { shallowMount, createLocalVue } from '@vue/test-utils'
import BaseIcon from './BaseIcon.vue'

const localVue = createLocalVue()

const name = 'name'
const width = 'width'
const height = 'height'

describe('BaseIcon', () => {
  it('Snapshop test for BaseIcon', () => {
    const wrapper = shallowMount(BaseIcon, {
      localVue,
      propsData: {
        name: name,
        width: width,
        height: height,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
