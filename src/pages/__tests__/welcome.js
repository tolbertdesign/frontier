import { shallowMount } from '@vue/test-utils'
import WelcomePage from '@/pages/welcome'

describe('welcome page', () => {
  test('mounts properly', () => {
    const wrapper = shallowMount(WelcomePage)
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  test('renders properly', () => {
    const wrapper = shallowMount(WelcomePage)
    expect(wrapper.html()).toMatchSnapshot()
  })
})
