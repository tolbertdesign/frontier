import { shallowMount, createLocalVue } from '@vue/test-utils'
import BusinessLeaderboard from './BusinessLeaderboard.vue'
import Vuex from 'vuex'
import axios from 'axios'
import LanguageParser from '@/mixins/LanguageParser'
jest.mock('axios')

function fakePledge (num) {
  return {
    id: num,
    program_id: 1,
    business_website: 'www.test' + num + '.com',
    business_name: 'Test' + num,
    comment: num % 2 === 0 ? 'Comment' : '',
    pledge_type_id: num % 2 === 0 ? 1 : 3,
    show_comment: num % 2 === 0 ? 1 : 0,
    laps: num % 2 === 0 ? num : 0,
    amount: 20,
    total_est: 100,
  }
}

const businessPledges = []
for (let i = 1; i <= 6; i++) {
  businessPledges.push(fakePledge(i))
}

axios.get.mockImplementation((url) => {
  if (url.startsWith('/v3/api/business-leaderboard-pledges')) {
    return Promise.resolve({ data: businessPledges })
  }
})

const localVue = createLocalVue()
localVue.use(Vuex)
localVue.filter('currency', jest.fn())
localVue.mixin(LanguageParser)

describe('BusinessLeaderboard', () => {
  let program = {}
  let store
  let storeProps

  beforeEach(() => {
    program = {
      id: 1,
      name: 'Program Name',
      unit_range_low: 1,
      unit_range_high: 2,
      participants: [
        {
          fr_code: 'FFFFFFFF',
        },
      ],
    }
    storeProps = {
      lang: {
        business_leaderboard_heading_1: 'heading 1',
        business_leaderboard_heading_2: 'heading 2',
        business_leaderboard_heading_3: 'heading 3',
        view: 'View',
        show: 'Show',
        less: 'Less',
        more: 'More',
        top_business_pledge: 'top pledge',
        note_goes_here: 'note goes here',
      },
    }
    store = new Vuex.Store({
      state: storeProps,
    })
  })

  it('is a Vue instance', () => {
    const wrapper = shallowMount(BusinessLeaderboard, {
      localVue,
      store,
      propsData: { program },
    })
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  it('renders correctly', done => {
    const wrapper = shallowMount(BusinessLeaderboard, {
      localVue,
      store,
      propsData: { program },
    })
    wrapper.vm.$nextTick(() => {
      expect(wrapper.html()).toMatchSnapshot()
      done()
    })
  })
})
