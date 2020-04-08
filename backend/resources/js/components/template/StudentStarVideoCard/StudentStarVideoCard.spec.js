import { shallowMount, createLocalVue } from '@vue/test-utils'
import AvatarImage from '@/components/element/AvatarImage'
import router from '@/router'

import StudentStarVideoCard from './StudentStarVideoCard.vue'

import '@/plugins/fontawesome'

const localVue = createLocalVue()

describe('StudentStarVideoCard', () => {
  const $store = {
    state: {
      lang: {
        student_star_video: {},
      },
    },
    gtag: jest.fn(),
  }
  const participant = {
    profile: {
      image_name: null,
    },
    participant_info: {
      pledges: [],
    },
  }

  it('matches snapshot', () => {
    const wrapper = shallowMount(StudentStarVideoCard, {
      localVue,
      router,
      mocks: { $store },
      propsData: { participant },
      components: { AvatarImage },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
