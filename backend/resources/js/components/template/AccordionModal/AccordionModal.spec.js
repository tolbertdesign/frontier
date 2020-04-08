import { shallowMount, createLocalVue } from '@vue/test-utils'
import AccordionModal from './AccordionModal.vue'
import Buefy from 'buefy'
import Blur from '@/mixins/Blur'
import '@/plugins/fontawesome'

const localVue = createLocalVue()
localVue.use(Buefy, {
  defaultIconPack: 'fas',
})

describe('AccordionModal', () => {
  it('Snapshop test for AccordionModal', () => {
    const wrapper = shallowMount(AccordionModal, {
      localVue,
      mixins: {
        Blur,
      },
      slots: {
        header: '<div>header slot</div>',
        default: '<div>default slot</div>',
        footer: '<div>footer slot</div>',
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
