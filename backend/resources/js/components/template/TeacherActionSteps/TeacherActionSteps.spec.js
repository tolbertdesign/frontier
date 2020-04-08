import { mount, createLocalVue } from '@vue/test-utils'
import TeacherActionSteps from './TeacherActionSteps.vue'
import Buefy from 'buefy'

const localVue = createLocalVue()
localVue.use(Buefy, {
  defaultIconPack: 'fas',
})

const className = 'classroom name'
const gradeDisplayName = 'grade display name'
const pledgeMeter = 30
const pledgeTotal = 100
const teacherParticipantId = 3

const task1 = {
  id: 1,
  title: 'Task 1',
  completed_on_date: null,
}

const task2 = {
  id: 2,
  title: 'Task 2',
  completed_on_date: '2020-01-01',
}

const tasks = [task1, task2]

const participant = {
  id: teacherParticipantId,
  participant_info: {
    classroom: {
      name: className,
      pledge_meter: pledgeMeter,
      grade: {
        display_name: gradeDisplayName,
      },
    },
  },
}

const program = {
  id: 1,
  participants: [participant],
}

const $store = {
  state: {
    User: {
      teacher_participant_id: teacherParticipantId,
      class_pledge_total: pledgeTotal,
    },
    lang: {
      all_tasks_complete: 'All tasks are complete',
      all_tasks_incomplete: 'All tasks are incomplete',
    },
  },
}

describe('TeacherActionSteps', () => {
  it('creates a snapshot', () => {
    const wrapper = mount(TeacherActionSteps, {
      localVue,
      mocks: { $store },
      propsData: {
        tasks: tasks,
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('checks computed properties of TeacherActionSteps', () => {
    const wrapper = mount(TeacherActionSteps, {
      localVue,
      mocks: { $store },
      propsData: {
        tasks: tasks,
        program: program,
      },
    })
    expect(wrapper.vm.incompleteTasks).toStrictEqual([task1])
    expect(wrapper.vm.completedTasks).toStrictEqual([task2])
    expect(wrapper.vm.classroomName).toBe(className)
    expect(wrapper.vm.participant).toBe(participant)
    expect(wrapper.vm.gradeName).toBe(gradeDisplayName)
    expect(wrapper.vm.pledgedTotal).toBe(pledgeTotal)
    expect(wrapper.vm.pledgeGoal).toBe(pledgeMeter)
  })
})
