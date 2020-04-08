import { shallowMount, createLocalVue } from '@vue/test-utils'
import DayBeforeFunrun from './DayBeforeFunrun.vue'

const localVue = createLocalVue()

const props = {
  event_name: 'event name',
  registration_code: 'registration code',
  due_date: 'due date',
  link: 'example.com',
  class_pledge_total: '500',
}

describe('DayBeforeFunrun', () => {
  it('Snapshop test for DayBeforeFunrun', () => {
    const wrapper = shallowMount(DayBeforeFunrun, {
      localVue,
      propsData: {
        props: props,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
