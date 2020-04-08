import { shallowMount, createLocalVue } from '@vue/test-utils'
import ParticipantCard from './ParticipantCard.vue'
import router from '@/router'
import AvatarImage from '@/components/element/AvatarImage'
import ProgressMeter from '@/components/element/ProgressMeter'

const localVue = createLocalVue()
localVue.filter('currency', jest.fn())

const $store = {
  state: {
    lang: {
      participant_card: {
        edit_profile_link: 'edit profile link',
        total_pledged: 'total pledged',
        of: 'of',
        pledge_goal: 'pledge goal',
        awaiting_confirmation: 'awaiting confirmation',
      },
      close: 'close',
      view: 'view',
      rewards: 'rewards',
    },
  },
  getters: {
    avatarPath: '',
  },
}
const selected = 1
const group = 5
const pledge1 = {
  id: 11,
  pledge_status_id: 2,
  pledge_type_id: 3,
  amount: 20,
}
const pledge2 = {
  id: 22,
  pledge_status_id: 1,
  pledge_type_id: 1,
  amount: 1.50,
}
const participant = {
  id: 7,
  first_name: 'first name',
  last_name: 'last name',
  profile: {
    pledge_goal: 1000,
    image_name: 'image name',
    fr_code: 'fr code',
  },
  participant_info: {
    pledges: [pledge1, pledge2],
  },
}
const program = {
  id: 8,
  participants: [participant],
  program_pledge_setting: {
    flat_donate_only: 0,
  },
  unit: {
    per: 'per',
    modifier: 'modifier',
  },
  unit_flat_conversion: 30,
}

describe('ParticipantCard', () => {
  it('Snapshop test for ParticipantCard', () => {
    const wrapper = shallowMount(ParticipantCard, {
      localVue,
      router,
      mocks: {
        $store,
      },
      components: {
        AvatarImage,
        ProgressMeter,
      },
      propsData: {
        program: program,
        participant: participant,
        selected: selected,
        group: group,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
