import { shallowMount } from '@vue/test-utils'
import ParentComponent from '@/components/ParentComponent'
import ChildComponent from '@/components/ChildComponent'

describe('ParentComponent.vue', () => {
  it('renders 3 Child components', () => {
    const wrapper = shallowMount(ParentComponent)
    expect(wrapper.findAll(ChildComponent).length).toBe(3)
  })
})
