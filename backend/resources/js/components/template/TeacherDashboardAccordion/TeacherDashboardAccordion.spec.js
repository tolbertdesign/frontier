import { shallowMount, createLocalVue } from '@vue/test-utils'
import TeacherDashboardAccordion from '@/components/template/TeacherDashboardAccordion'
import Accordion from '@/components/element/Accordion'
import ParticipantCard from '@/components/template/ParticipantCard'
import PledgeAndShare from '@/components/template/PledgeAndShare'
import ProgramOverview from '@/components/template/ProgramOverview'
import TeacherDashboard from '@/components/template/TeacherDashboard'
import SchoolGoalAndStats from '@/components/template/SchoolGoalAndStats'
import HowToGetPledges from '@/components/template/HowToGetPledges'
import StudentStarVideo from '@/components/template/StudentStarVideo'
import PledgeInfo from '@/components/template/PledgeInfo'
import ReadMoreComponent from '@/components/element/ReadMoreComponent'
import BusinessLeaderboard from '@/components/template/BusinessLeaderboard'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const localVue = createLocalVue()

const $store = {
  state: {
    User: {
      teacher_participant_id: 1,
    },
    lang: {
      personal_pledge_process: 'Personal Pledge Process',
    },
  },
}

window.matchMedia = jest.fn().mockImplementation(query => {
  return {
    matches: false,
    media: query,
    onchange: null,
    addListener: jest.fn(),
    removeListener: jest.fn(),
  }
})

const program = {
  participants: [
    {
      id: 1,
      profile: {
        image_name: 'imageName',
      },
      participant_info: {
        pledges: [],
      },
    },
  ],
  ssv_disabled: 0,
}

describe('TeacherDashboardAccordion', () => {
  it('Snapshop test for TeacherDashboardAccordion', () => {
    const wrapper = shallowMount(TeacherDashboardAccordion, {
      localVue,
      mocks: {
        $store: $store,
      },
      components: {
        Accordion,
        TeacherDashboard,
        ParticipantCard,
        PledgeAndShare,
        ProgramOverview,
        SchoolGoalAndStats,
        HowToGetPledges,
        StudentStarVideo,
        PledgeInfo,
        BusinessLeaderboard,
        FontAwesomeIcon,
        ReadMoreComponent,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('Snapshop test for TeacherDashboardAccordion with ssv_disabled turned on', () => {
    program.ssv_disabled = 1
    const wrapper = shallowMount(TeacherDashboardAccordion, {
      localVue,
      mocks: {
        $store: $store,
      },
      components: {
        Accordion,
        TeacherDashboard,
        ParticipantCard,
        PledgeAndShare,
        ProgramOverview,
        SchoolGoalAndStats,
        HowToGetPledges,
        StudentStarVideo,
        PledgeInfo,
        BusinessLeaderboard,
        FontAwesomeIcon,
        ReadMoreComponent,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
