import { shallowMount, createLocalVue } from '@vue/test-utils'
import ContactsTable from './ContactsTable.vue'
import RemoveContactModal from '@/components/template/RemoveContactModal'
import EmailPreviousSponsorsModal from '@/components/template/EmailPreviousSponsorsModal'
import PledgingStatus from '@/utilities/PledgingStatus'
import Blur from '@/mixins/Blur'

const localVue = createLocalVue()

const $store = {
  state: {
    lang: {
      email_previous_sponsors: 'email previous sponsors',
      select_all: 'select all',
      unselect_all: 'unselect all',
      contact: 'contact',
      status: 'status',
      previous_sponsor: 'previous sponsor',
      easy_emailer_status: [
        'sent',
        'not sent',
      ],
    },
  },
}
const contacts = []
const allSelected = true

describe('ContactsTable', () => {
  it('Snapshop test for ContactsTable', () => {
    const wrapper = shallowMount(ContactsTable, {
      localVue,
      mixins: {
        Blur,
      },
      components: {
        RemoveContactModal,
        EmailPreviousSponsorsModal,
        PledgingStatus,
      },
      mocks: {
        $store,
      },
      propsData: {
        allSelected: allSelected,
        contacts: contacts,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
