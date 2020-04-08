import { shallowMount, createLocalVue } from '@vue/test-utils'
import TeacherIncentives from './TeacherIncentives.vue'

const localVue = createLocalVue()

describe('TeacherIncentives', () => {
  const $storeForTeacher = {
    state: {
      User: {
        is_teacher_user: true,
      },
      s3Bucket: 'AWS_Bucket',
    },
  }

  const $storeNotForTeacher = {
    state: {
      User: {
        is_teacher_user: false,
      },
      s3Bucket: 'AWS_Bucket',
    },
  }

  it('matches snapshot when user is a teacher and incentives are not hidden', () => {
    const wrapper = shallowMount(TeacherIncentives, {
      localVue,
      mocks: { $store: $storeForTeacher },
      propsData: {
        hide_teacher_incentives: false,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('matches snapshot when user is a teacher and incentives are hidden', () => {
    const wrapper = shallowMount(TeacherIncentives, {
      localVue,
      mocks: { $store: $storeForTeacher },
      propsData: {
        hide_teacher_incentives: true,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('matches snapshot when user is not a teacher and incentives are not hidden', () => {
    const wrapper = shallowMount(TeacherIncentives, {
      localVue,
      mocks: { $store: $storeNotForTeacher },
      propsData: {
        hide_teacher_incentives: false,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
