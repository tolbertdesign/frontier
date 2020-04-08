import { shallowMount, createLocalVue } from '@vue/test-utils'
import VideoIframe from '@/components/element/VideoIframe'
import StudentStarVideo from './StudentStarVideo.vue'

const localVue = createLocalVue()

describe('StudentStarVideo', () => {
  const $store = {
    state: {
      lang: {
        student_star_video: {},
      },
    },
    watch: jest.fn(),
    gtag: jest.fn(),
  }
  const program = {
    participants: [
      {
        profile: {
          image_name: null,
        },
        participant_info: {
          pledges: [],
        },
      },
    ],
  }

  it('matches snapshot', () => {
    const wrapper = shallowMount(StudentStarVideo, {
      localVue,
      mocks: { $store },
      propsData: { program },
      components: { VideoIframe },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
