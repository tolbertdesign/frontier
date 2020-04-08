import { shallowMount, createLocalVue } from '@vue/test-utils'
import TeamDayTwo from './TeamDayTwo.vue'

const localVue = createLocalVue()

const props = {
  event_name: 'event name',
  registration_code: 'registration code',
  due_date: 'due date',
  link: 'example.com',
  class_pledge_total: '500',
}

describe('TeamDayTwo', () => {
  it('Snapshop test for TeamDayTwo', () => {
    const wrapper = shallowMount(TeamDayTwo, {
      localVue,
      propsData: {
        props: props,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
