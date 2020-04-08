import { mount } from '@vue/test-utils'
import Logo from '@/components/AppLogo'

describe('AppLogo.vue', () => {
  test('is a Vue instance', () => {
    const wrapper = mount(Logo)
    expect(wrapper.isVueInstance()).toBeTruthy()
  })
})
