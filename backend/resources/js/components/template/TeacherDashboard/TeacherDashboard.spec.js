import { shallowMount, createLocalVue } from '@vue/test-utils'
import TeacherDashboard from './TeacherDashboard.vue'
import TeacherIncentives from '@/components/template/TeacherIncentives'
import ProgressMeter from '@/components/element/ProgressMeter'
import Buefy from 'buefy'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import '@/plugins/fontawesome'

const localVue = createLocalVue()
localVue.use(Buefy, {
  defaultIconPack: 'fas',
})

const program = {
  participants: [
    {
      profile: {
        image_name: 'imageName',
      },
    },
  ],
}

const $store = {
  getters: {
    teacherParticipant: (program) => {
      return program.participants[0]
    },
  },
}

describe('TeacherDashboard', () => {
  it('Snapshop test for TeacherDashboard', () => {
    const wrapper = shallowMount(TeacherDashboard, {
      localVue,
      mocks: { $store },
      components: {
        TeacherIncentives,
        ProgressMeter,
        FontAwesomeIcon,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
