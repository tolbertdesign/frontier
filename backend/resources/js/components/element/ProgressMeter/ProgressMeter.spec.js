import { shallowMount, createLocalVue } from '@vue/test-utils'
import ProgressMeter from './ProgressMeter.vue'

const localVue = createLocalVue()

const color = 'color'
const backgroundColorClass = 'background color class'
const goal = 5
const firstMeter = 1
const secondMeter = 2
const showValue = true
const valueToDisplay = 'value to display'

describe('ProgressMeter', () => {
  it('Snapshop test for ProgressMeter', () => {
    const wrapper = shallowMount(ProgressMeter, {
      localVue,
      propsData: {
        color: color,
        backgroundColorClass: backgroundColorClass,
        goal: goal,
        firstMeter: firstMeter,
        secondMeter: secondMeter,
        showValue: showValue,
        valueToDisplay: valueToDisplay,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for ProgressMeter computed/method', () => {
    const wrapper = shallowMount(ProgressMeter, {
      localVue,
      propsData: {
        color: color,
        backgroundColorClass: backgroundColorClass,
        goal: goal,
        firstMeter: firstMeter,
        secondMeter: secondMeter,
        showValue: showValue,
        valueToDisplay: valueToDisplay,
      },
    })
    expect(wrapper.vm.firstMeterPercentage).toBe(20)
    expect(wrapper.vm.secondMeterPercentage).toBe(60)
    expect(wrapper.vm.getPercentage(30, 60)).toBe(50)
    expect(wrapper.vm.getPercentage('invalid', 100)).toBe(0)
    expect(wrapper.vm.getPercentage(10, 'invalid')).toBe(0)
    expect(wrapper.vm.getPercentage(5, 1)).toBe(100)
    expect(wrapper.vm.getPercentagePosition(90)).toStrictEqual({ right: '10%' })
    expect(wrapper.vm.getPercentagePosition(10)).toStrictEqual({ left: '0%' })
  })
})
