import { shallowMount, createLocalVue } from '@vue/test-utils'
import Accordion from './Accordion.vue'
import Buefy from 'buefy'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import '@/plugins/fontawesome'

const localVue = createLocalVue()
localVue.use(Buefy, {
  defaultIconPack: 'fas',
})

const title = 'title'
describe('Accordion', () => {
  it('Snapshop test for open Accordion', () => {
    const wrapper = shallowMount(Accordion, {
      localVue,
      slots: {
        default: '<div>default slot</div>',
        toggle: '<div>toggle slot</div>',
      },
      components: {
        FontAwesomeIcon,
      },
      propsData: {
        title: title,
        isOpen: true,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for closed Accordion', () => {
    const wrapper = shallowMount(Accordion, {
      localVue,
      slots: {
        default: '<div>default slot</div>',
        toggle: '<div>toggle slot</div>',
        title: '<div>title slot</div>',
      },
      components: {
        FontAwesomeIcon,
      },
      propsData: {
        title: title,
        isOpen: false,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
