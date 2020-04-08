import { shallowMount, createLocalVue } from '@vue/test-utils'
import PledgeButton from './PledgeButton.vue'
import RoundedButton from '@/components/element/RoundedButton'

const localVue = createLocalVue()

const participants = [
  {
    id: 1,
    fr_code: 'bad fr code',
    deleted: 1,
  },
  {
    id: 2,
    fr_code: 'good fr code',
    deleted: 0,
  },
]
describe('PledgeButton', () => {
  it('Snapshop test for PledgeButton and confirm computed fr_code value', () => {
    const wrapper = shallowMount(PledgeButton, {
      localVue,
      components: {
        RoundedButton,
      },
      propsData: {
        participants: participants,
      },
    })
    expect(wrapper).toMatchSnapshot()
    expect(wrapper.vm.fr_code).toBe('good fr code')
  })
})
