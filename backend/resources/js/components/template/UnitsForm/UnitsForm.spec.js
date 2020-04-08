import { shallowMount, createLocalVue } from '@vue/test-utils'
import UnitsForm from './UnitsForm.vue'

const localVue = createLocalVue()

describe('UnitsForm', () => {
  it('renders units form correctly when editable', () => {
    const wrapper = shallowMount(UnitsForm, {
      propsData: {
        units: 30,
        participantUserId: 5,
        unitNamePlural: 'laps',
        unitMax: 35,
      },
      localVue,
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('renders units form correctly when not editable', () => {
    const wrapper = shallowMount(UnitsForm, {
      propsData: {
        units: 30,
        participantUserId: 6,
        unitNamePlural: 'reading challenges',
        unitMax: 35,
        canEdit: false,
      },
      localVue,
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('displays the correct number of options in the unit select input', () => {
    const wrapper = shallowMount(UnitsForm, {
      propsData: {
        units: 15,
        participantUserId: 7,
        unitNamePlural: 'laps',
        unitMax: 19,
        canEdit: true,
      },
      localVue,
    })
    expect(wrapper.vm.unitRange.length).toEqual(10)
  })
})
