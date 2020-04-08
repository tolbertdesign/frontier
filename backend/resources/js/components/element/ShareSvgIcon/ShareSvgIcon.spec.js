import { shallowMount, createLocalVue } from '@vue/test-utils'
import ShareSvgIcon from './ShareSvgIcon.vue'

const localVue = createLocalVue()

const type = 'facebook'

describe('ShareSvgIcon', () => {
  it('Snapshop test for facebook ShareSvgIcon', () => {
    const wrapper = shallowMount(ShareSvgIcon, {
      localVue,
      propsData: {
        type: type,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for email ShareSvgIcon', () => {
    const wrapper = shallowMount(ShareSvgIcon, {
      localVue,
      propsData: {
        type: 'email',
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for ssv ShareSvgIcon', () => {
    const wrapper = shallowMount(ShareSvgIcon, {
      localVue,
      propsData: {
        type: 'ssv',
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for script ShareSvgIcon', () => {
    const wrapper = shallowMount(ShareSvgIcon, {
      localVue,
      propsData: {
        type: 'script',
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
