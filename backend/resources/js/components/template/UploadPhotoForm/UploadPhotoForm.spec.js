import { createLocalVue, shallowMount } from '@vue/test-utils'
import UploadPhotoForm from './UploadPhotoForm.vue'
import Croppa from 'vue-croppa'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

const localVue = createLocalVue()
localVue.use(Croppa)
describe('UploadPhotoForm', () => {
  const lang = {
    edit_participant: {
      save: 'save',
      student_star_wait: 'student star wait text',
    },
    upload_photo_desc: 'upload photo desc',
    upload_photo_desc_disabled_ssv: 'upload photo desc disabled ssv',
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
        components: {
          FontAwesomeIcon,
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
    expect(wrapper.text()).toContain(lang.upload_photo_desc)
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
        components: {
          FontAwesomeIcon,
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
    expect(wrapper.text()).toContain(lang.upload_photo_desc)
  })
})
