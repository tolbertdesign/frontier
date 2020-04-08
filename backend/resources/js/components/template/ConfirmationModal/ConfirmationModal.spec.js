import { shallowMount, createLocalVue } from '@vue/test-utils'
import ConfirmationModal from './ConfirmationModal.vue'
import Blur from '@/mixins/Blur'

const localVue = createLocalVue()

const $store = {
  state: {
    lang: {
      about_to_delete: 'about to delete',
      continue: 'continue',
      delete: 'delete',
      cancel: 'cancel',
    },
  },
}

describe('ConfirmationModal', () => {
  it('Snapshop test for ConfirmationModal', () => {
    const wrapper = shallowMount(ConfirmationModal, {
      localVue,
      mixins: {
        Blur,
      },
      mocks: {
        $store,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
