import { shallowMount, createLocalVue } from '@vue/test-utils'
import PreviousSponsorShareButton from './PreviousSponsorShareButton.vue'
import router from '@/router'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const localVue = createLocalVue()

const participants = [
  { id: 3 },
  { id: 1 },
  { id: 2 },
]
const ga_page_location = 'ga page location'
const ga_site_location = 'ga site location'

const $store = {
  state: {
    lang: {
      view_previous_sponsors_button: 'view previous sponsors button',
    },
  },
}

describe('PreviousSponsorShareButton', () => {
  it('Snapshop test for PreviousSponsorShareButton', () => {
    const wrapper = shallowMount(PreviousSponsorShareButton, {
      localVue,
      router,
      mocks: {
        $store,
      },
      components: {
        FontAwesomeIcon,
      },
      propsData: {
        participants: participants,
        ga_page_location: ga_page_location,
        ga_site_location: ga_site_location,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Test getSmallestParticipantId method', () => {
    const wrapper = shallowMount(PreviousSponsorShareButton, {
      localVue,
      router,
      mocks: {
        $store,
      },
      components: {
        FontAwesomeIcon,
      },
      propsData: {
        participants: participants,
        ga_page_location: ga_page_location,
        ga_site_location: ga_site_location,
      },
    })
    expect(wrapper.vm.getSmallestParticipantId()).toBe(1)
  })
})
