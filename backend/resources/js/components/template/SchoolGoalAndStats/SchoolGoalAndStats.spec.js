import { shallowMount, createLocalVue } from '@vue/test-utils'
import SchoolGoalAndStats from './SchoolGoalAndStats.vue'
import Vuex from 'vuex'
import axios from 'axios'
import ParentSeeder from '@/seed/parent.json'
import mutateUser from '@/utilities/mutateUser'
jest.mock('axios')

const localVue = createLocalVue()
localVue.use(Vuex)
localVue.filter('currency', jest.fn())

describe('SchoolGoalAndStats', () => {
  const parent = mutateUser(ParentSeeder)
  const program = parent.programs[0]
  let store
  let storeProps

  program.total_raised_goal = 10
  axios.get.mockImplementation((url) => {
    if (url.startsWith('/v3/api/programs-total-pledged/' + program.id)) {
      return Promise.resolve({ data: 5 })
    } else if (url.startsWith('/v3/api/programs/classroom-pledge-totals/' + program.id)) {
      return Promise.resolve({ data: 5 })
    }
  })

  beforeEach(() => {
    storeProps = {
      lang: '',
    }
    store = new Vuex.Store({
      state: storeProps,
      gtag: jest.fn(),
    })
  })

  it('is a Vue instance', () => {
    const wrapper = shallowMount(SchoolGoalAndStats, {
      localVue,
      store,
      propsData: { program },
    })
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  it('calculates goal not met correctly', done => {
    const wrapper = shallowMount(SchoolGoalAndStats, {
      localVue,
      store,
      propsData: { program },
    })
    wrapper.vm.$nextTick(() => {
      expect(wrapper.html()).toMatchSnapshot()
      expect(wrapper.vm.progressPercentage).toBe(50)
      done()
    })
  })

  it('calculates goal met correctly', done => {
    program.total_raised_goal = 5
    const wrapper = shallowMount(SchoolGoalAndStats, {
      localVue,
      store,
      propsData: { program },
    })
    wrapper.vm.$nextTick(() => {
      expect(wrapper.html()).toMatchSnapshot()
      expect(wrapper.vm.progressPercentage).toBe(100)
      done()
    })
  })

  it('it calculates goal correctly when client_goal is 0', done => {
    program.total_raised_goal = 0
    const wrapper = shallowMount(SchoolGoalAndStats, {
      localVue,
      store,
      propsData: { program },
    })
    wrapper.vm.$nextTick(() => {
      expect(wrapper.html()).toMatchSnapshot()
      expect(wrapper.vm.hasGoalBeenMet).toBe(true)
      done()
    })
  })

  it('chunks classrooms correctly', done => {
    const wrapper = shallowMount(SchoolGoalAndStats, {
      localVue,
      store,
      propsData: { program },
    })

    const classrooms = [
      { id: 1, name: 'a' }, { id: 2, name: 'b' }, { id: 3, name: 'c' }, { id: 4, name: 'd' }, { id: 5, name: 'e' },
    ]

    const classroomChunks = wrapper.vm.getClassroomChunks(
      program.participants,
      classrooms,
    )

    expect(classroomChunks[0][0].id).toBe(1)
    expect(classroomChunks[0][1].id).toBe(2)
    done()
  })

  it('hides other grade text', done => {
    const wrapper = shallowMount(SchoolGoalAndStats, {
      localVue,
      store,
      propsData: { program },
    })

    const classroom = { gradeText: '' }
    const gradeText = wrapper.vm.getGradeText(classroom)

    expect(gradeText).toBe('')

    done()
  })

  it('shows grade text', done => {
    const wrapper = shallowMount(SchoolGoalAndStats, {
      localVue,
      store,
      propsData: { program },
    })

    const classroom = { gradeText: '1st Grade' }
    const gradeText = wrapper.vm.getGradeText(classroom)

    expect(gradeText).toBe(' - 1st Grade')

    done()
  })
})
