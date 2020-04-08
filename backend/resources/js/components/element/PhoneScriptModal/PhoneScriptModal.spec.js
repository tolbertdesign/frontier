import { shallowMount, createLocalVue } from '@vue/test-utils'
import PhoneScriptModal from './PhoneScriptModal.vue'
import Blur from '@/mixins/Blur'

const localVue = createLocalVue()

const parseLanguage = jest.fn(input => input)
const $store = {
  state: {
    User: {},
    lang: {
      header: 'header',
      close: 'close',
      p1: 'p1',
      p2: 'p2',
      p3: 'p3',
      p4: 'p4',
      p5: 'p5',
      p6: 'p6',
      p7: 'p7',
      p8: 'p8',
      p9: 'p9',
      how_to_get_pledges: {
        phone_script: 'phone script',
      },
    },
  },
}
const program = {
  id: 1,
  event_name: 'Event Name',
  unit_range_low: 'unit range low',
  unit_range_high: 'unit range high',
  unit_max_charge: 'unit max charge',
  unit: {
    name: 'lap',
    name_plural: 'laps',

  },
}
describe('PhoneScriptModal', () => {
  it('Snapshop test for PhoneScriptModal', () => {
    const wrapper = shallowMount(PhoneScriptModal, {
      localVue,
      mixins: {
        Blur,
      },
      mocks: {
        $store,
        parseLanguage: parseLanguage,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
