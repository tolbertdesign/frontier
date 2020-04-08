import { shallowMount } from '@vue/test-utils'
import BaseInput from './BaseInput'

describe('BaseInput', () => {
  it('is called', () => {
    const wrapper = shallowMount(BaseInput, {
      propsData: {
        v: { },
      },
    })
    expect(wrapper.name()).toBe('BaseInput')
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  it('render correctly', () => {
    const wrapper = shallowMount(BaseInput, {
      propsData: {
        v: { },
      },
    })
    expect(wrapper.html()).toMatchSnapshot()
  })
})
