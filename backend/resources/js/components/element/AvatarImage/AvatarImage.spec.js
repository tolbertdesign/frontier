import { shallowMount, createLocalVue } from '@vue/test-utils'
import AvatarImage from './AvatarImage.vue'

const localVue = createLocalVue()

const alt = 'alt'
const src = 'src'
const shouldEmit = true
const small = true

describe('AvatarImage', () => {
  it('Snapshop test for small AvatarImage and check computed class for size', () => {
    const wrapper = shallowMount(AvatarImage, {
      localVue,
      propsData: {
        alt: alt,
        src: src,
        shouldEmit: shouldEmit,
        small: small,
      },
    })
    expect(wrapper).toMatchSnapshot()
    expect(wrapper.vm.size).toBe('w-9 h-9')
  })
  it('Snapshop test for not small AvatarImage and check computed class for size', () => {
    const wrapper = shallowMount(AvatarImage, {
      localVue,
      propsData: {
        alt: alt,
        src: src,
        shouldEmit: shouldEmit,
        small: false,
      },
    })
    expect(wrapper).toMatchSnapshot()
    expect(wrapper.vm.size).toBe('w-16 h-16')
  })
})
