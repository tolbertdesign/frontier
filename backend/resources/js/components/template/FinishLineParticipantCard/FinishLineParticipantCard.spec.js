import { shallowMount, createLocalVue } from '@vue/test-utils'
import FinishLineParticipantCard from './FinishLineParticipantCard.vue'

const localVue = createLocalVue()

describe('FinishLineParticipantCard', () => {
  const participant = {
    id: 5,
    first_name: 'Jane',
    last_name: 'Doe',
    profile: {
      image_name: 'test-image',
    },
  }

  const unit = {
    name_plural: 'Name Plural',
  }

  const $store = {
    getters: {
      avatarPath: 'avatar-path',
    },
  }

  it('renders finish line participant card correctly', () => {
    const wrapper = shallowMount(FinishLineParticipantCard, {
      mocks: { $store },
      propsData: {
        participant,
        unit,
        unitMax: 30,
      },
      localVue,
    })
    expect(wrapper).toMatchSnapshot()
  })
})
