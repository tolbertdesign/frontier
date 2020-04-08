import { shallowMount, createLocalVue } from '@vue/test-utils'
import PledgeAndShare from './PledgeAndShare.vue'
import PledgeButton from '@/components/element/PledgeButton'
import ShareButtons from '@/components/pattern/ShareButtons'

const localVue = createLocalVue()
const program = {}
const participant1 = {}
const participant2 = {}
const showAskPreviousSponsors = true
const showPayPledgesOnline = true
const participants = [participant1, participant2]

describe('PledgeAndShare', () => {
  it('Snapshop test for PledgeAndShare', () => {
    const wrapper = shallowMount(PledgeAndShare, {
      localVue,
      components: {
        PledgeButton,
        ShareButtons,
      },
      propsData: {
        showAskPreviousSponsors: showAskPreviousSponsors,
        showPayPledgesOnline: showPayPledgesOnline,
        participants: participants,
        program: program,
      },
    })
    expect(wrapper).toMatchSnapshot()
  })
})
