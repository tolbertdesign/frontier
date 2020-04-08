import Vue from 'vue'
import { mount, shallowMount } from '@vue/test-utils'
import Widget from '@/components/Widget'

// helper function that mounts and returns the rendered text
function getRenderedText (Component, propsData) {
  const Constructor = Vue.extend(Component)
  const vm = new Constructor({ propsData: propsData }).$mount()
  return vm.$el.textContent
}

describe('Widget.vue', () => {
  it('is a Vue instance', () => {
    const wrapper = mount(Widget)
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  // Inspect the raw component options
  it('has a created hook', () => {
    expect(typeof Widget.created).toBe('function')
  })

  // Evaluate the results of functions in
  // the raw component options
  it('sets the correct default data', () => {
    expect(typeof Widget.data).toBe('function')
    const defaultData = Widget.data()
    expect(defaultData.message).toBe('Hello Vue Testing')
  })

  // Inspect the component instance on mount
  it('correctly sets the message when created', () => {
    const vm = new Vue(Widget).$mount()
    expect(vm.message).toBe('Bye!')
  })

  // Mount an instance and inspect the render output
  it('renders the correct message', () => {
    const Constructor = Vue.extend(Widget)
    const vm = new Constructor().$mount()
    expect(vm.$el.textContent).toContain('Bye!')
  })

  // https://vuejs.org/v2/guide/unit-testing.html#Asserting-Asynchronous-Updates
  // Inspect the generated HTML after a state update
  it('updates the rendered message when vm.message updates', done => {
    const vm = new Vue(Widget).$mount()
    vm.message = 'foo'

    // wait a "tick" after state change before asserting DOM updates
    Vue.nextTick(() => {
      expect(vm.$el.textContent).toContain('foo')
      done()
    })
  })

  it('renders props.type when passed', () => {
    const type = 'new type'
    const wrapper = shallowMount(Widget, {
      propsData: { type },
    })
    expect(wrapper.text()).toContain(type)
  })

  it('renders correctly with different props', () => {
    expect(
      getRenderedText(Widget, {
        type: 'notification',
      }),
    ).toContain('notification')

    expect(
      getRenderedText(Widget, {
        type: 'alert',
      }),
    ).toContain('alert')
  })
})
