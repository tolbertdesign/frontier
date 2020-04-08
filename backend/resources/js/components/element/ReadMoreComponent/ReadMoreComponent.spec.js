import { shallowMount, createLocalVue } from '@vue/test-utils'
import ReadMoreComponent from './ReadMoreComponent.vue'

const localVue = createLocalVue()

const text = 'text'
const limit = 200
const limitHeight = true
const moreText = 'moreText'
const lessText = 'lessText'

describe('ReadMoreComponent', () => {
  it('Snapshop test for ReadMoreComponent', () => {
    const wrapper = shallowMount(ReadMoreComponent, {
      localVue,
      propsData: {
        text: text,
        limit: limit,
        limitHeight: limitHeight,
        moreText: moreText,
        lessText: lessText,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
