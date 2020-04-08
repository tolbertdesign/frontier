import { shallowMount, createLocalVue } from '@vue/test-utils'
import ParticipantRewardsCard from './ParticipantRewardsCard.vue'
import Blur from '@/mixins/Blur'

const localVue = createLocalVue()

const $store = {
  state: {
    lang: {
      more: 'more',
      pending: 'pending',
      giveaway: 'giveaway',
      delivered: 'delivered',
    },
    s3Bucket: 'S3-bucket',
  },
}
const prize = {
  picture: 'picture',
  video: 'video',
}
const unassignedReward = {
  prizeBound: {
    actual_amount: 25,
    display_amount: 30,
  },
  prize: prize,
  status: 'unassigned',
}
const pendingReward = {
  prizeBound: {
    actual_amount: 35,
    display_amount: 40,
  },
  prize: prize,
  status: 'pending',
}
const deliveredReward = {
  prizeBound: {
    actual_amount: 15,
    display_amount: 20,
  },
  prize: prize,
  status: 'delivered',
}
const giveawayReward = {
  prizeBound: {
    actual_amount: 5,
    display_amount: 10,
  },
  prize: prize,
  status: 'giveaway',
}
const program = {
  id: 8,
  program_pledge_setting: {
    flat_donate_only: 0,
  },
  unit: {
    modifier: 'modifier',
    name: 'name',
  },
  unit_flat_conversion: 30,
}
describe('ParticipantRewardsCard', () => {
  it('Snapshop test for ParticipantRewardsCard with unassigned reward', () => {
    const wrapper = shallowMount(ParticipantRewardsCard, {
      localVue,
      mixins: {
        Blur,
      },
      mocks: {
        $store,
      },
      propsData: {
        sumPledgesFlat: 100,
        reward: unassignedReward,
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
describe('ParticipantRewardsCard', () => {
  it('Snapshop test for ParticipantRewardsCard with pending reward', () => {
    const wrapper = shallowMount(ParticipantRewardsCard, {
      localVue,
      mixins: {
        Blur,
      },
      mocks: {
        $store,
      },
      propsData: {
        sumPledgesFlat: 200,
        reward: pendingReward,
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
describe('ParticipantRewardsCard', () => {
  it('Snapshop test for ParticipantRewardsCard with giveaway reward', () => {
    const wrapper = shallowMount(ParticipantRewardsCard, {
      localVue,
      mixins: {
        Blur,
      },
      mocks: {
        $store,
      },
      propsData: {
        sumPledgesFlat: 300,
        reward: giveawayReward,
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
describe('ParticipantRewardsCard', () => {
  it('Snapshop test for ParticipantRewardsCard with delivered reward', () => {
    const wrapper = shallowMount(ParticipantRewardsCard, {
      localVue,
      mixins: {
        Blur,
      },
      mocks: {
        $store,
      },
      propsData: {
        sumPledgesFlat: 400,
        reward: deliveredReward,
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
