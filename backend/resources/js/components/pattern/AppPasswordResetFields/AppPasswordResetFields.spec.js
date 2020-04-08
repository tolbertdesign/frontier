import { shallowMount, createLocalVue } from '@vue/test-utils'
import AppPasswordResetFields from './AppPasswordResetFields.vue'

const localVue = createLocalVue()

const emailAddressLabel = 'email address label'
const passwordLabel = 'password label'
const passwordConfirmLabel = 'password confirm label'
const error = 'error'

describe('AppPasswordResetFields', () => {
  it('Snapshop test for AppPasswordResetFields', () => {
    const wrapper = shallowMount(AppPasswordResetFields, {
      localVue,
      propsData: {
        emailAddressLabel: emailAddressLabel,
        passwordLabel: passwordLabel,
        passwordConfirmLabel: passwordConfirmLabel,
        error: error,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
