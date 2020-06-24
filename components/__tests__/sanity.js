import {mount} from '@vue/test-utils'
import EmailInput from '@/components/EmailInput'

describe('EmailInput', () => {
  it('has "Enter your email" as the default placeholder', () => {
    const wrapper = mount(EmailInput)
    expect(wrapper.attributes('placeholder')).toBe('Enter your email')
  })
  it('has the class "form-input"', () => {
    const wrapper = mount(EmailInput)
    expect(wrapper.classes()).toContain('form-input')
  })
  it('has "email" as it’s type', () => {
    const wrapper = mount(EmailInput)
    expect(wrapper.attributes('type')).toBe('email')
  })
})
