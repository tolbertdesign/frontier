import { shallowMount } from '@vue/test-utils'
import AppHeader from './AppHeader.vue'
import '@/plugins/fontawesome'
import router from '@/router'

describe('AppHeader', () => {
  const $store = {
    state: {
      User: {
        group_membership: [],
        programs: [],
      },
      lang: {
        pledge_info: {},
      },
    },
    getters: {
      activePrograms () {
        return []
      },
    },
    gtag: jest.fn(),
  }

  const orgAdmin = {
    state: {
      User: {
        group_membership: [50],
        programs: [],
      },
      lang: {
        pledge_info: {},
      },
    },
    getters: {
      activePrograms () {
        return []
      },
    },
    gtag: jest.fn(),
  }

  it('does not show admin link when user isn’t and Org administrator', () => {
    const wrapper = shallowMount(AppHeader, {
      router,
      mocks: { $store },
    })
    expect(wrapper.find('.org-admin-link').exists()).toBe(false)
    expect(wrapper.vm.isOrgAdmin).toBe(false)
  })

  it('shows admin link when user is an Org administrator', () => {
    const wrapper = shallowMount(AppHeader, {
      router,
      mocks: { $store: orgAdmin },
    })
    expect(wrapper.find('.org-admin-link').exists()).toBe(true)
    expect(wrapper.vm.isOrgAdmin).toBe(true)
  })

  it('matches snapshot', () => {
    const wrapper = shallowMount(AppHeader, {
      router,
      mocks: { $store },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
