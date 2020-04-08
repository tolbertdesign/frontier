import { shallowMount, createLocalVue } from '@vue/test-utils'
import TeamDay from './TeamDay.vue'

const localVue = createLocalVue()

const props = {
  event_name: 'event name',
  registration_code: 'registration code',
  due_date: 'due date',
  link: 'example.com',
  class_pledge_total: '500',
}

describe('TeamDay', () => {
  it('Snapshop test for TeamDay', () => {
    const wrapper = shallowMount(TeamDay, {
      localVue,
      propsData: {
        props: props,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
