import { shallowMount, createLocalVue } from '@vue/test-utils'
import RoundedButton from './RoundedButton.vue'

const localVue = createLocalVue()

const text = 'text'
const link = 'link'

describe('RoundedButton', () => {
  it('Snapshop test for RoundedButton', () => {
    const wrapper = shallowMount(RoundedButton, {
      localVue,
      propsData: {
        text: text,
        link: link,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
