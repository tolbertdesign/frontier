import { shallowMount, createLocalVue } from '@vue/test-utils'
import DayAfterFunrun from './DayAfterFunrun.vue'

const localVue = createLocalVue()

const props = {
  event_name: 'event name',
  registration_code: 'registration code',
  due_date: 'due date',
  link: 'example.com',
  class_pledge_total: '500',
}

describe('DayAfterFunrun', () => {
  it('Snapshop test for DayAfterFunrun', () => {
    const wrapper = shallowMount(DayAfterFunrun, {
      localVue,
      propsData: {
        props: props,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
