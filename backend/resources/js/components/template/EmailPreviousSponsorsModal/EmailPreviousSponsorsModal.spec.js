import { shallowMount, createLocalVue } from '@vue/test-utils'
import EmailPreviousSponsorsModal from './EmailPreviousSponsorsModal.vue'
import SendEnvelope from '@/components/element/SendEnvelope.vue'

const localVue = createLocalVue()

const previousSponsors = [
  { id: 1 },
  { id: 2 },
]
const $store = {
  state: {
    lang: {
      email_send_to: 'email send to',
      contact: 'contact',
      about_to_email_previous: 'about to email previous',
      cancel: 'cancel',
      send: 'send',
    },
  },
}

describe('EmailPreviousSponsorsModal', () => {
  it('Snapshop test for EmailPreviousSponsorsModal', () => {
    const wrapper = shallowMount(EmailPreviousSponsorsModal, {
      localVue,
      components: {
        SendEnvelope,
      },
      mocks: {
        $store,
      },
      propsData: {
        previousSponsors: previousSponsors,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
