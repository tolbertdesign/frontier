import { shallowMount, createLocalVue } from '@vue/test-utils'
import RemoveContactModal from './RemoveContactModal.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const localVue = createLocalVue()

describe('RemoveContactModal', () => {
  it('Snapshop test for RemoveContactModal', () => {
    const wrapper = shallowMount(RemoveContactModal, {
      localVue,
      components: {
        FontAwesomeIcon,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
