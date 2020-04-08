import { shallowMount, createLocalVue } from '@vue/test-utils'
import TeacherPledgeMeter from './TeacherPledgeMeter.vue'
import ProgressMeter from '@/components/element/ProgressMeter'

const localVue = createLocalVue()
localVue.filter('currency', jest.fn())
localVue.component('ProgressMeter', ProgressMeter)

const $store = {
  state: {
    User: {
      class_last_name: 'Test',
    },
    lang: {
      student_star_video: {},
    },
  },
  watch: jest.fn(),
}

const program = {
  unit: {
    modifier: 'per',
    name: 'Reading Challenge',
  },
  program_pledge_setting: {
    flat_donate_only: 0,
  },
  participants: [
    {
      profile: {
        pledge_goal: 100,
      },
      participant_info: {
        classroom: {
          grade: {
            display_name: 'Classroom Grade Display Name',
          },
        },
      },
    },
  ],
}

describe('TeacherPledgeMeter', () => {
  it('matches snapshot', () => {
    const wrapper = shallowMount(TeacherPledgeMeter, {
      localVue,
      mocks: { $store },
      propsData: { program },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
