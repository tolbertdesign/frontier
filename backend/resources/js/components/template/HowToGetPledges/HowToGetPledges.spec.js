import { shallowMount, createLocalVue } from '@vue/test-utils'
import HowToGetPledges from './HowToGetPledges.vue'
import PhoneScriptModal from '@/components/element/PhoneScriptModal'
import ShareSvgIcon from '@/components/element/ShareSvgIcon'
import Blur from '@/mixins/Blur'
import router from '@/router'
import VideoIframe from '@/components/element/VideoIframe'

const localVue = createLocalVue()

const $store = {
  state: {
    lang: {
      how_to_get_pledges: {
        asking_for_pledges: 'asking for pledges',
        email: {
          link: 'link',
          paragraph: 'paragraph',
        },
        share_on_facebook: 'share on facebook',
        get_sponsor_pledges: 'get sponsor pledges',
        share_ssv: 'share ssv',
        customize_it: 'customize it',
        use_our_phone_script: 'use our phone script',
        call_friends: 'call friends',
      },
    },
  },
}

const program = {
  id: 99,
  ssv_disabled: 0,
  participants: [
    {
      id: 1,
      special_urls: 'special URLs 1',
    },
    {
      id: 2,
      special_urls: 'special URLs 2',
    },
    {
      id: 3,
      special_urls: 'special URLs 3',
    },
  ],
}

describe('HowToGetPledges', () => {
  it('Snapshop test for HowToGetPledges', () => {
    const wrapper = shallowMount(HowToGetPledges, {
      localVue,
      router,
      mixins: {
        Blur,
      },
      components: {
        PhoneScriptModal,
        ShareSvgIcon,
        VideoIframe,
      },
      mocks: {
        $store,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })

  it('Snapshop test for HowToGetPledges with ssv disabled', () => {
    program.ssv_disabled = 1
    const wrapper = shallowMount(HowToGetPledges, {
      localVue,
      router,
      mixins: {
        Blur,
      },
      components: {
        PhoneScriptModal,
        ShareSvgIcon,
        VideoIframe,
      },
      mocks: {
        $store,
      },
      propsData: {
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
