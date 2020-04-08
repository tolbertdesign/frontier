import { shallowMount } from '@vue/test-utils'
import ParticipantRewards from './ParticipantRewards.vue'
import PledgeTotalCalculator from '@/utilities/PledgeTotalCalculator.js'
import { STATUS_ABANDONED, STATUS_PENDING, STATUS_CONFIRMED, STATUS_PAID, STATUS_PAYMENT_SCHEDULED, PLEDGE_TYPE_PPL, PLEDGE_TYPE_FLAT } from '@/store/modules/pledge.js'

describe('ParticipantRewards', () => {
  let participant
  beforeEach(() => {
    participant = {
      prizes: [
      ],
      participant_info: {
        prize_bound_students: [
        ],
        classroom: {
          group: {
            prizes_bound: [
            ],
          },
        },
      },
    }
  })

  it('is a Vue instance', () => {
    const wrapper = shallowMount(ParticipantRewards)
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  it('is computes basic rewards', () => {
    addPrize(1)
    const wrapper = shallowMount(ParticipantRewards, {
      propsData: { participant },
    })
    expect(wrapper.vm.getCombinedPrizeObjects().length).toBe(1)
    expect(wrapper.vm.rewards.length).toBe(1)
  })

  it('is computes rewards removing activity rewards', () => {
    addPrize(1)
    addPrize(2, true)
    const wrapper = shallowMount(ParticipantRewards, {
      propsData: { participant },
    })
    expect(wrapper.vm.getCombinedPrizeObjects().length).toBe(2)
    expect(wrapper.vm.rewards.length).toBe(1)
  })

  it('is computes rewards removing quantity rewards', () => {
    addPrize(1, null, null, null, true)
    const wrapper = shallowMount(ParticipantRewards, {
      propsData: { participant },
    })
    expect(wrapper.vm.getCombinedPrizeObjects().length).toBe(1)
    expect(wrapper.vm.rewards.length).toBe(0)
  })

  it('is computes rewards keeping prizes inside of time window', () => {
    const yesterday = (d => new Date(d.setDate(d.getDate() - 1)))(new Date())
    const tomorrow = (d => new Date(d.setDate(d.getDate() + 1)))(new Date())
    addPrize(1, null, yesterday, tomorrow)
    const wrapper = shallowMount(ParticipantRewards, {
      propsData: { participant },
    })
    expect(wrapper.vm.getCombinedPrizeObjects().length).toBe(1)
    expect(wrapper.vm.rewards.length).toBe(1)
  })
  it('is computes rewards removing prizes out of time window', () => {
    const dayBeforeYesterday = (d => new Date(d.setDate(d.getDate() - 2)))(new Date())
    const yesterday = (d => new Date(d.setDate(d.getDate() - 1)))(new Date())
    addPrize(1, null, dayBeforeYesterday, yesterday)
    const wrapper = shallowMount(ParticipantRewards, {
      propsData: { participant },
    })
    expect(wrapper.vm.getCombinedPrizeObjects().length).toBe(1)
    expect(wrapper.vm.rewards.length).toBe(0)
  })

  it('is computes pledge totals correctly', () => {
    const program = { unit_flat_conversion: 30 }
    const pledges = [
      { pledge_type_id: PLEDGE_TYPE_PPL, pledge_status_id: STATUS_PAID, amount: 5 },
      { pledge_type_id: PLEDGE_TYPE_PPL, pledge_status_id: STATUS_PAID, amount: 15 },
      { pledge_type_id: PLEDGE_TYPE_PPL, pledge_status_id: STATUS_ABANDONED, amount: 15 },
      { pledge_type_id: PLEDGE_TYPE_FLAT, pledge_status_id: STATUS_CONFIRMED, amount: 3 },
      { pledge_type_id: PLEDGE_TYPE_FLAT, pledge_status_id: STATUS_CONFIRMED, amount: 12 },
    ]

    const calculator = new PledgeTotalCalculator(program, pledges, [
      STATUS_CONFIRMED,
      STATUS_PAID,
      STATUS_PAYMENT_SCHEDULED,
      STATUS_PENDING,
    ])
    expect(calculator.getTotalAsFlat()).toBe(615)
    expect(calculator.getTotalAsPPL()).toBe(20.5)
  })

  const addPrize = (id, activity_reward = null, starts_at = null, ends_at = null, quantity = null) => {
    participant.prizes.push({ id })
    participant.participant_info.prize_bound_students.push({ prize_id: id })
    participant.participant_info.classroom.group.prizes_bound.push(
      {
        prize_id: id,
        activity_reward,
        starts_at,
        ends_at,
        quantity,
      },
    )
  }
})
