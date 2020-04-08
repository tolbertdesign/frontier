import { shallowMount, createLocalVue } from '@vue/test-utils'
import WeekendChallenge from './WeekendChallenge.vue'

const localVue = createLocalVue()

const props = {
  event_name: 'event name',
  registration_code: 'registration code',
  due_date: 'due date',
  link: 'example.com',
  class_pledge_total: '500',
}

describe('WeekendChallenge', () => {
  it('Snapshop test for WeekendChallenge', () => {
    const wrapper = shallowMount(WeekendChallenge, {
      localVue,
      propsData: {
        props: props,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
