import { shallowMount, createLocalVue } from '@vue/test-utils'
import VideoGallery from './VideoGallery.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const localVue = createLocalVue()

const video1 = {
  external_video_id: '12345678',
  source: 'vimeo',
}

const video2 = {
  external_video_id: '98765432',
  source: 'youtube',
}

const videos = [
  video1,
  video2,
]

describe('VideoGallery', () => {
  it('Snapshop test for VideoGallery', () => {
    const wrapper = shallowMount(VideoGallery, {
      localVue,
      components: {
        FontAwesomeIcon,
      },
      propsData: {
        videos,
        selectedVideoId: video2.external_video_id,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
