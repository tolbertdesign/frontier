import { shallowMount, createLocalVue } from '@vue/test-utils'
import AppLoginFields from './AppLoginFields.vue'

const localVue = createLocalVue()

const emailAddressLabel = 'email address label'
const passwordLabel = 'password label'
const rememberMeLabel = 'remember me label'
const showPasswordLabel = 'show password label'
const error = 'error'

describe('AppLoginFields', () => {
  it('Snapshop test for AppLoginFields', () => {
    const wrapper = shallowMount(AppLoginFields, {
      localVue,
      propsData: {
        emailAddressLabel: emailAddressLabel,
        passwordLabel: passwordLabel,
        rememberMeLabel: rememberMeLabel,
        showPasswordLabel: showPasswordLabel,
        error: error,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
