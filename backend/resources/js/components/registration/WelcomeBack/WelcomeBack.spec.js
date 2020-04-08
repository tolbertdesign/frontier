import { shallowMount, createLocalVue } from '@vue/test-utils'
import WelcomeBack from './WelcomeBack.vue'

const localVue = createLocalVue()

const $store = {
  state: {
    lang: {
      welcome_back: 'welcome back',
      back_to_dashboard: 'back to dashboard',
      admin_dashboard: 'admin dashboard',
      im_a_teacher: 'I am a teacher',
      im_a_parent: 'I am a parent',
      im_a_student: 'I am a student',
      im_a_sponsor: 'I am a sponsor',
      what_does_this_mean: 'what does this mean',
    },
  },
}
const isBetaUser = false
const isOrgAdmin = false

describe('WelcomeBack', () => {
  it('Snapshop test for default WelcomeBack', () => {
    const wrapper = shallowMount(WelcomeBack, {
      localVue,
      mocks: {
        $store: $store,
        hjTrigger: jest.fn(),
        gaEvent: jest.fn(),
      },
      propsData: {
        isBetaUser: isBetaUser,
        isOrgAdmin: isOrgAdmin,
      },
    })
    expect(wrapper).toMatchSnapshot()
    expect(wrapper.vm.buttonText).toBe($store.state.lang.im_a_parent)
  })
  it('Snapshop test for beta user WelcomeBack', () => {
    const wrapper = shallowMount(WelcomeBack, {
      localVue,
      mocks: {
        $store: $store,
        hjTrigger: jest.fn(),
        gaEvent: jest.fn(),
      },
      propsData: {
        isBetaUser: true,
        isOrgAdmin: isOrgAdmin,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for org admin user WelcomeBack', () => {
    const wrapper = shallowMount(WelcomeBack, {
      localVue,
      mocks: {
        $store: $store,
        hjTrigger: jest.fn(),
        gaEvent: jest.fn(),
      },
      propsData: {
        isBetaUser: isBetaUser,
        isOrgAdmin: true,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for org admin and beta banner user WelcomeBack', () => {
    const wrapper = shallowMount(WelcomeBack, {
      localVue,
      mocks: {
        $store: $store,
        hjTrigger: jest.fn(),
        gaEvent: jest.fn(),
      },
      propsData: {
        isBetaUser: true,
        isOrgAdmin: true,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
