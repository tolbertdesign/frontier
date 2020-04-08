import { shallowMount, createLocalVue } from '@vue/test-utils'
import AddContactsModal from './AddContactsModal.vue'
import AddContactsButtons from '@/components/template/AddContactsButtons'
import Buefy from 'buefy'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const localVue = createLocalVue()
localVue.use(Buefy, {
  defaultIconPack: 'fas',
})

const $store = {
  state: {
    lang: {
      email_sent: 'email sent',
      first_name: 'first name',
      last_name: 'last name',
      email_address: 'email address',
    },
  },
}

describe('AddContactsModal', () => {
  it('Snapshop test for AddContactsModal', () => {
    const wrapper = shallowMount(AddContactsModal, {
      localVue,
      components: {
        AddContactsButtons,
        FontAwesomeIcon,
      },
      mocks: {
        $store,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
