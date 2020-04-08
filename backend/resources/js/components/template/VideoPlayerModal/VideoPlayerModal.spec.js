import { shallowMount, createLocalVue } from '@vue/test-utils'
import VideoPlayerModal from './VideoPlayerModal.vue'

const localVue = createLocalVue()

describe('VideoPlayerModal', () => {
  it('Snapshop test for VideoPlayerModal', () => {
    const wrapper = shallowMount(VideoPlayerModal, {
      localVue,
      propsData: {
        videoId: 12345678,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
