import { shallowMount, createLocalVue } from '@vue/test-utils'
import Buefy from 'buefy'
import Vuelidate from 'vuelidate'
import { VTooltip } from 'v-tooltip'
import EditParticipantForm from './EditParticipantForm.vue'
import FontAwesomeIcon from '@/plugins/fontawesome'
import currency from '@/filters/currency'
import { $store, $v, participant, participantFlatDonateOnly, settings } from './TestData'
import LanguageParser from '../../../mixins/LanguageParser'

const localVue = createLocalVue()
localVue.use(Buefy, {
  defaultIconPack: 'fas',
})

localVue.use(Vuelidate)
localVue.directive('tooltip', VTooltip)
localVue.component('AvatarImage', require('@/components/element/AvatarImage'))
localVue.component('BaseInput', require('@/components/element/BaseInput'))
localVue.component('FontAwesomeIcon', FontAwesomeIcon)
localVue.filter('Currency', currency)
localVue.component('RouterLink', require())
localVue.mixin(LanguageParser)

describe('EditParticipantForm', () => {
  it('is a Vue instance', () => {
    const wrapper = shallowMount(EditParticipantForm, {
      mocks: { $store, $v },
      propsData: { participant, settings },
      localVue,
    })
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  it('renders edit participant form', () => {
    const wrapper = shallowMount(EditParticipantForm, {
      mocks: { $store, $v },
      propsData: { participant, settings },
      localVue,
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('shows per unit if program is ppu', () => {
    const wrapper = shallowMount(EditParticipantForm, {
      mocks: { $store, $v },
      propsData: {
        participant,
        settings,
      },
      localVue,
    })
    expect(wrapper.text()).toContain('Pledge Goal')
    expect(wrapper.text()).toContain(': per reading challenge')
  })

  it('does not show per unit if program is flat only', () => {
    const wrapper = shallowMount(EditParticipantForm, {
      mocks: { $store, $v },
      propsData: {
        participant: participantFlatDonateOnly,
        settings,
      },
      localVue,
    })
    expect(wrapper.text()).toContain('Pledge Goal')
    expect(wrapper.text()).not.toContain(': per reading challenge')
  })
})
