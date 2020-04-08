import { shallowMount, createLocalVue } from '@vue/test-utils'
import LoadingOverlay from './LoadingOverlay.vue'
import Buefy from 'buefy'

const localVue = createLocalVue()
localVue.use(Buefy, {
  defaultIconPack: 'fas',
})

const isLoading = true
const isFullPage = true

describe('LoadingOverlay', () => {
  it('Snapshop test for LoadingOverlay', () => {
    const wrapper = shallowMount(LoadingOverlay, {
      localVue,
      propsData: {
        isLoading: isLoading,
        isFullPage: isFullPage,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
