import { shallowMount, createLocalVue } from '@vue/test-utils'
import PledgeReminderModal from './PledgeReminderModal.vue'
import Blur from '@/mixins/Blur'

const localVue = createLocalVue()

const $store = {
  state: {
    lang: {
      send_explanation: 'send explanation',
      continue: 'continue',
      send: 'send',
      cancel: 'cancel',
      success: 'success',
      reminder_error: 'reminder error',
      close: 'close',
    },
  },
}

const pledgeId = 1

describe('PledgeReminderModal', () => {
  it('Snapshop test for PledgeReminderModal', () => {
    const wrapper = shallowMount(PledgeReminderModal, {
      localVue,
      mixins: {
        Blur,
      },
      mocks: {
        $store,
      },
      propsData: {
        pledgeId: pledgeId,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
