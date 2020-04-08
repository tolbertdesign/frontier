import { shallowMount, createLocalVue } from '@vue/test-utils'
import ContentLibraryButton from './ContentLibraryButton.vue'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const localVue = createLocalVue()

const $store = {
  state: {
    lang: {
      content_library_button: 'content library button',
    },
  },
}

describe('ContentLibraryButton', () => {
  it('Snapshop test for ContentLibraryButton', () => {
    const wrapper = shallowMount(ContentLibraryButton, {
      localVue,
      mocks: {
        $store,
      },
      components: {
        FontAwesomeIcon,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
