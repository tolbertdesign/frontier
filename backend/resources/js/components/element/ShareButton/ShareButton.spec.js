import { shallowMount, createLocalVue } from '@vue/test-utils'
import ShareButton from './ShareButton.vue'
import ClipboardJS from 'clipboard'
import * as bootstrap from 'bootstrap'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import ParticipantDisplayNames from '@/mixins/ParticipantDisplayNames'

const localVue = createLocalVue()
localVue.use(bootstrap)
localVue.mixin(ParticipantDisplayNames)
const parseLanguage = jest.fn(input => input)
const $store = {
  state: {
    lang: {
      easy_emailer_button: 'easy emailer button',
      sms_button: 'sms button',
      copy_and_share_button: 'copy and share button',
      facebook_button: 'facebook button',
      sms: {
        has_video: 'has video',
        no_video: 'no video',
      },
    },
  },
}

const type = 'type'
const participants = [
  { id: 1 },
  { id: 2 },
  { id: 3 },
]
const specialUrls = [
  {
    referrer: {
      name: 'Link_Video',
    },
    short_key: 'short key 1',
  },
  {
    referrer: {
      name: 'Link',
    },
    short_key: 'short key 2',
  },
  {
    referrer: {
      name: 'Facebook_Video',
    },
    short_key: 'short key 1',
  },
  {
    referrer: {
      name: 'Facebook',
    },
    short_key: 'short key 2',
  },
  {
    referrer: {
      name: 'SMS_Video',
    },
    short_key: 'short key 1',
  },
  {
    referrer: {
      name: 'SMS',
    },
    short_key: 'short key 2',
  },
]
const hasVideo = true
const program = {
  event_name: 'event name',
}
const ga_page_location = 'ga page location'
const ga_site_location = 'ga site location'

describe('ShareButton', () => {
  it('Snapshop test for facebook ShareButton with a video', () => {
    const wrapper = shallowMount(ShareButton, {
      localVue,
      mocks: {
        $store,
        parseLanguage,
      },
      components: {
        FontAwesomeIcon,
        ClipboardJS,
      },
      propsData: {
        type: type,
        participants: participants,
        specialUrls: specialUrls,
        hasVideo: hasVideo,
        program: program,
        ga_page_location: ga_page_location,
        ga_site_location: ga_site_location,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for facebook ShareButton without a video', () => {
    const wrapper = shallowMount(ShareButton, {
      localVue,
      mocks: {
        $store,
        parseLanguage,
      },
      components: {
        FontAwesomeIcon,
        ClipboardJS,
      },
      propsData: {
        type: type,
        participants: participants,
        specialUrls: specialUrls,
        hasVideo: false,
        program: program,
        ga_page_location: ga_page_location,
        ga_site_location: ga_site_location,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for email ShareButton with a video', () => {
    const wrapper = shallowMount(ShareButton, {
      localVue,
      mocks: {
        $store,
        parseLanguage,
      },
      components: {
        FontAwesomeIcon,
        ClipboardJS,
      },
      propsData: {
        type: 'email',
        participants: participants,
        specialUrls: specialUrls,
        hasVideo: hasVideo,
        program: program,
        ga_page_location: ga_page_location,
        ga_site_location: ga_site_location,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for email ShareButton without a video', () => {
    const wrapper = shallowMount(ShareButton, {
      localVue,
      mocks: {
        $store,
        parseLanguage,
      },
      components: {
        FontAwesomeIcon,
        ClipboardJS,
      },
      propsData: {
        type: 'email',
        participants: participants,
        specialUrls: specialUrls,
        hasVideo: false,
        program: program,
        ga_page_location: ga_page_location,
        ga_site_location: ga_site_location,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for link ShareButton with a video', () => {
    const wrapper = shallowMount(ShareButton, {
      localVue,
      mocks: {
        $store,
        parseLanguage,
      },
      components: {
        FontAwesomeIcon,
        ClipboardJS,
      },
      propsData: {
        type: 'link',
        participants: participants,
        specialUrls: specialUrls,
        hasVideo: hasVideo,
        program: program,
        ga_page_location: ga_page_location,
        ga_site_location: ga_site_location,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for link ShareButton without a video', () => {
    const wrapper = shallowMount(ShareButton, {
      localVue,
      mocks: {
        $store,
        parseLanguage,
      },
      components: {
        FontAwesomeIcon,
        ClipboardJS,
      },
      propsData: {
        type: 'link',
        participants: participants,
        specialUrls: specialUrls,
        hasVideo: false,
        program: program,
        ga_page_location: ga_page_location,
        ga_site_location: ga_site_location,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for SMS ShareButton with a video', () => {
    const wrapper = shallowMount(ShareButton, {
      localVue,
      mocks: {
        $store,
        parseLanguage,
      },
      components: {
        FontAwesomeIcon,
        ClipboardJS,
      },
      propsData: {
        type: 'sms',
        participants: participants,
        specialUrls: specialUrls,
        hasVideo: hasVideo,
        program: program,
        ga_page_location: ga_page_location,
        ga_site_location: ga_site_location,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
  it('Snapshop test for SMS ShareButton without a video', () => {
    const wrapper = shallowMount(ShareButton, {
      localVue,
      mocks: {
        $store,
        parseLanguage,
      },
      components: {
        FontAwesomeIcon,
        ClipboardJS,
      },
      propsData: {
        type: 'sms',
        participants: participants,
        specialUrls: specialUrls,
        hasVideo: false,
        program: program,
        ga_page_location: ga_page_location,
        ga_site_location: ga_site_location,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
