import { shallowMount, createLocalVue } from '@vue/test-utils'
import ProgramOverview from './ProgramOverview.vue'
import Buefy from 'buefy'
import VideoPlayer from '@/components/template/VideoPlayer'
import ReadMoreComponent from '@/components/element/ReadMoreComponent'

jest.mock('axios')
const parseLanguage = jest.fn(input => input)

const localVue = createLocalVue()
localVue.use(Buefy, {
  defaultIconPack: 'fas',
})

const defaultIsTeacherUser = true
const defaultHideCharacterVideos = true
const namePluralDefault = 'name plural'
const eventNameDefault = 'event name'
const micrositeOverviewTextOverrideDefault = 'microsite overview text override'
const langOverviewTextOverrideDefault = 'lang overview text override'
const parentCharacterVideosTitle = 'Parent Character Videos'
const teacherCharacterVideosTitle = 'Teacher Character Videos'

const program = {
  id: 1,
  event_name: eventNameDefault,
  unit: {
    name_plural: namePluralDefault,
  },
  microsite: {
    overview_text_override: micrositeOverviewTextOverrideDefault,
    hide_character_videos: defaultHideCharacterVideos,
  },
  participants: [
    { id: 2 },
  ],
}

const $store = {
  state: {
    User: {
      is_teacher_user: defaultIsTeacherUser,
      programs: [program],
    },
    lang: {
      overview_text_override: langOverviewTextOverrideDefault,
      teacher_character_videos_title: teacherCharacterVideosTitle,
      parent_character_videos_title: parentCharacterVideosTitle,
    },
  },
}

describe('ProgramOverview', () => {
  it('Snapshop test for ProgramOverview', () => {
    const wrapper = shallowMount(ProgramOverview, {
      localVue,
      components: {
        VideoPlayer,
        ReadMoreComponent,
      },
      mocks: {
        $store: $store,
        parseLanguage: parseLanguage,
      },
      propsData: {
        program: program,
      },
    })
    wrapper.vm.$nextTick(() => {
      expect(wrapper).toMatchSnapshot()
    })
  })
  it('has correct length for video collection when character videos are hidden', () => {
    const wrapper = shallowMount(ProgramOverview, {
      localVue,
      components: {
        VideoPlayer,
        ReadMoreComponent,
      },
      mocks: {
        $store: $store,
        parseLanguage: parseLanguage,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper.vm.videoCategoriesArray.length).toBe(1)
  })
  it('has character videos title and length for videos array when character videos are not hidden for a teacher', () => {
    program.microsite.hide_character_videos = false

    const wrapper = shallowMount(ProgramOverview, {
      localVue,
      components: {
        VideoPlayer,
        ReadMoreComponent,
      },
      mocks: {
        $store: $store,
        parseLanguage: parseLanguage,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper.vm.videoCategoriesArray.length).toBe(2)
    expect(wrapper.vm.videoCategoriesArray[0].title).toBe(teacherCharacterVideosTitle)
    program.microsite.hide_character_videos = defaultHideCharacterVideos
  })
  it('has character videos title and length for videos array when character videos are not hidden for a parent', () => {
    program.microsite.hide_character_videos = false
    $store.state.User.is_teacher_user = false

    const wrapper = shallowMount(ProgramOverview, {
      localVue,
      components: {
        VideoPlayer,
        ReadMoreComponent,
      },
      mocks: {
        $store: $store,
        parseLanguage: parseLanguage,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper.vm.videoCategoriesArray.length).toBe(2)
    expect(wrapper.vm.videoCategoriesArray[1].title).toBe(parentCharacterVideosTitle)
    program.microsite.hide_character_videos = defaultHideCharacterVideos
    $store.state.User.is_teacher_user = true
  })
  it('has correct title for character videos for teacher users and a correct program description', () => {
    const wrapper = shallowMount(ProgramOverview, {
      localVue,
      components: {
        VideoPlayer,
        ReadMoreComponent,
      },
      mocks: {
        $store: $store,
        parseLanguage: parseLanguage,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper.vm.characterVideosTitle).toBe(teacherCharacterVideosTitle)
    expect(wrapper.vm.programDescription).toBe(micrositeOverviewTextOverrideDefault)
  })
  it('has correct title for character videos for parent users', () => {
    $store.state.User.is_teacher_user = false
    const wrapper = shallowMount(ProgramOverview, {
      localVue,
      components: {
        VideoPlayer,
        ReadMoreComponent,
      },
      mocks: {
        $store: $store,
        parseLanguage: parseLanguage,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper.vm.characterVideosTitle).toBe(parentCharacterVideosTitle)
    $store.state.User.is_teacher_user = defaultIsTeacherUser
  })
  it('has correct program description when program does not have a description', () => {
    program.microsite.overview_text_override = null
    const wrapper = shallowMount(ProgramOverview, {
      localVue,
      components: {
        VideoPlayer,
        ReadMoreComponent,
      },
      mocks: {
        $store: $store,
        parseLanguage: parseLanguage,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper.vm.programDescription).toBe(langOverviewTextOverrideDefault)
    program.microsite.overview_text_override = micrositeOverviewTextOverrideDefault
  })
  it('adds character videos to correct location in array for teacher', () => {
    const stubbedValue = 'programVideoStub'
    const videoArray = [
      stubbedValue,
    ]

    const wrapper = shallowMount(ProgramOverview, {
      localVue,
      components: {
        VideoPlayer,
        ReadMoreComponent,
      },
      mocks: {
        $store: $store,
        parseLanguage: parseLanguage,
      },
      propsData: {
        program: program,
      },
    })
    wrapper.vm.addCharacterVideos(videoArray)
    expect(videoArray.length).toBe(2)
    expect(videoArray[0]).not.toBe(stubbedValue)
    expect(videoArray[1]).toBe(stubbedValue)
  })
  it('adds character videos to correct location in array for parent', () => {
    $store.state.User.is_teacher_user = false
    const stubbedValue = 'programVideoStub'
    const videoArray = [
      stubbedValue,
    ]

    const wrapper = shallowMount(ProgramOverview, {
      localVue,
      components: {
        VideoPlayer,
        ReadMoreComponent,
      },
      mocks: {
        $store: $store,
        parseLanguage: parseLanguage,
      },
      propsData: {
        program: program,
      },
    })
    wrapper.vm.addCharacterVideos(videoArray)
    expect(videoArray.length).toBe(2)
    expect(videoArray[0]).toBe(stubbedValue)
    expect(videoArray[1]).not.toBe(stubbedValue)
    $store.state.User.is_teacher_user = true
  })
})
