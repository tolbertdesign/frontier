import { shallowMount, createLocalVue } from '@vue/test-utils'
import VideoIframe from './VideoIframe.vue'

const localVue = createLocalVue()

const source = 'vimeo'
const videoId = '123456789'
const color = '111111'
const autoplay = false
const configId = 'JcxcCN5H'

describe('VideoIframe', () => {
  it('Snapshop test for VideoIframe', () => {
    const wrapper = shallowMount(VideoIframe, {
      localVue,
      propsData: {
        source: source,
        videoId: videoId,
        color: color,
        autoplay: autoplay,
        configId: configId,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
