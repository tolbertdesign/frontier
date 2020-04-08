import { shallowMount, createLocalVue } from '@vue/test-utils'
import VideoPlayer from './VideoPlayer.vue'
import VideoGallery from '@/components/template/VideoGallery'
import VideoIframe from '@/components/element/VideoIframe'
import ContentLibraryButton from '@/components/element/ContentLibraryButton'
import Buefy from 'buefy'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const localVue = createLocalVue()
localVue.use(Buefy, {
  defaultIconPack: 'fas',
})

const $teacherStore = {
  state: {
    User: {
      is_teacher_user: true,
    },
  },
}

const $parentStore = {
  state: {
    User: {
      is_teacher_user: false,
    },
  },
}

const video1 = {
  external_video_id: '12345678',
  source: 'vimeo',
}

const video2 = {
  external_video_id: '98765432',
  source: 'youtube',
}

const videoCollections = [
  {
    title: 'Title',
    videos: [
      video1,
      video2,
    ],
  },
]

describe('VideoPlayer', () => {
  it('Snapshop test for teacher VideoPlayer and has correct preset video for teachers', () => {
    const wrapper = shallowMount(VideoPlayer, {
      localVue,
      components: {
        ContentLibraryButton,
        VideoGallery,
        FontAwesomeIcon,
      },
      mocks: {
        $store: $teacherStore,
      },
      propsData: {
        videoCollections: videoCollections,
        presetVideo: video1,
      },
    })
    expect(wrapper).toMatchSnapshot()
    expect(wrapper.vm.activeVideo).toBe(video1)
  })
})

describe('VideoPlayer', () => {
  it('Snapshop test for parent VideoPlayer and has correct preset video for parents', () => {
    const wrapper = shallowMount(VideoPlayer, {
      localVue,
      components: {
        ContentLibraryButton,
        VideoGallery,
        VideoIframe,
      },
      mocks: {
        $store: $parentStore,
      },
      propsData: {
        videoCollections: videoCollections,
        presetVideo: video2,
      },
    })
    expect(wrapper).toMatchSnapshot()
    expect(wrapper.vm.activeVideo).toBe(video2)
  })
})
