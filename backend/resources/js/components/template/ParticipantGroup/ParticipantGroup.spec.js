import { shallowMount, createLocalVue } from '@vue/test-utils'
import ParticipantGroup from './ParticipantGroup.vue'
import ParticipantCard from '@/components/template/ParticipantCard'
import ParticipantRewards from '@/components/template/ParticipantRewards'

const localVue = createLocalVue()

const participant1 = { id: 1 }
const participant2 = { id: 2 }
const program = { id: 9 }

describe('ParticipantGroup', () => {
  it('Snapshop test for ParticipantGroup with one participant', () => {
    const wrapper = shallowMount(ParticipantGroup, {
      localVue,
      components: {
        ParticipantCard,
        ParticipantRewards,
      },
      propsData: {
        program: program,
        participantGroup: [participant1],
        hasOnlyOneParticipant: true,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
describe('ParticipantGroup', () => {
  it('Snapshop test for ParticipantGroup with two participants', () => {
    const wrapper = shallowMount(ParticipantGroup, {
      localVue,
      components: {
        ParticipantCard,
        ParticipantRewards,
      },
      propsData: {
        program: program,
        participantGroup: [participant1, participant2],
        hasOnlyOneParticipant: false,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
