import { createLocalVue, shallowMount } from '@vue/test-utils'
import UploadPhotoForm from './UploadPhotoForm.vue'
import Croppa from 'vue-croppa'

const localVue = createLocalVue()
localVue.use(Croppa)
describe('UploadPhotoForm', () => {
  const lang = {
    student_star_wait: 'student star wait text',
    participant_registration: {
      upload_photo: 'upload photo lang',
    },
  }
  const $store = {
    state: {
      lang,
    },
    subscribe: jest.fn(),
  }
  it('Snapshot ssv not disabled show student star wait text UploadPhotoForm', () => {
    const wrapper = shallowMount(
      UploadPhotoForm, {
        localVue,
        mocks: { $store },
        propsData: {
          ssvDisabled: false,
          lang,
        },
        data: () => {
          return {
            myCroppa: {
              hasImage: () => true,
              generateDataUrl: jest.fn(),
            },
          }
        },
      })
    expect(wrapper.html()).toContain('<p class="student_star_wait text-14 mw-250px mx-auto">' + lang.student_star_wait + '</p>')
  })

  it('Snapshot ssv disabled hides student star wait text UploadPhotoForm', () => {
    const wrapper = shallowMount(
      UploadPhotoForm, {
        localVue,
        mocks: { $store },
        propsData: {
          ssvDisabled: true,
          lang,
        },
        data: () => {
          return {
            myCroppa: {
              hasImage: () => true,
              generateDataUrl: jest.fn(),
            },
          }
        },
      })
    expect(wrapper.html()).toContain('<p class="student_star_wait text-14 mw-250px mx-auto invisible">' + lang.student_star_wait + '</p>')
  })
})
