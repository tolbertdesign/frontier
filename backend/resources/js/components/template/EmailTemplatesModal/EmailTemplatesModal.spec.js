import { shallowMount, createLocalVue } from '@vue/test-utils'
import EmailTemplatesModal from './EmailTemplatesModal'
import LanguageParser from '@/mixins/LanguageParser'
import Buefy from 'buefy'
import '@/plugins/fontawesome'

const localVue = createLocalVue()
localVue.use(Buefy, {
  defaultIconPack: 'fas',
})

localVue.mixin(LanguageParser)

describe('EmailTemplatesModal', () => {
  const $route = {
    params: {
      participantUserId: 2,
    },
  }
  const user = {
    first_name: 'Martha',
    programs: [
      {
        id: 1,
        event_name: 'Event Name',
        microsite: {
          funds_raised_for: 'Funds are needed for technology',
        },
        unit: {
          name: 'lap',
          name_plural: 'laps',
          modifier: 'per',

        },
        participants: [
          {
            id: 2,
            user_id: 3,
            first_name: 'Megan',
            profile: {
              pledge_goal: 100,
            },
            special_urls: [
              {
                id: 1,
                user_id: 3,
                referrer: {
                  id: 6,
                },
                short_key: 'AbCdEf',
              },
              {
                id: 2,
                user_id: 3,
                referrer: {
                  id: 7,
                },
                short_key: 'gHiJkL',
              },
              {
                id: 3,
                user_id: 3,
                referrer: {
                  id: 8,
                },
                short_key: 'mNoPqR',
              },
            ],
          },
        ],
      },
    ],
  }

  const participant2 = {
    id: 13,
    user_id: 68,
    first_name: 'Sallie',
    profile: {
      pledge_goal: 10,
    },
    special_urls: [
      {
        id: 5,
        user_id: 68,
        referrer: {
          id: 6,
        },
        short_key: 'IUYjhg',
      },
      {
        id: 6,
        user_id: 68,
        referrer: {
          id: 7,
        },
        short_key: 'jhYUGjb',
      },
      {
        id: 7,
        user_id: 68,
        referrer: {
          id: 8,
        },
        short_key: 'WEkJHGg',
      },
    ],
  }

  const participant3 = {
    id: 40,
    user_id: 80,
    first_name: 'Mary',
    profile: {
      pledge_goal: 15,
    },
    special_urls: [
      {
        id: 9,
        user_id: 80,
        referrer: {
          id: 6,
        },
        short_key: 'artsyer',
      },
      {
        id: 20,
        user_id: 80,
        referrer: {
          id: 7,
        },
        short_key: 'sgfKHdd',
      },
      {
        id: 30,
        user_id: 80,
        referrer: {
          id: 8,
        },
        short_key: 'ppPjbvs',
      },
    ],
  }

  const $store = {
    state: {
      User: user,
      lang: {
        emails_we_send: 'Emails We Send',
        sponsor_name: 'Sponsor Name',
        template: 'Coming up, :names :is_are participating in the :event_name and :is_are helping raise funds for :funds_raised_for. :names will complete 30-35 :plural_unit_name in the :event_name as a $:pledge_goal :unit_modifier :unit_name pledge goal. Will you help us?',
        click_here_reach_for_greatness: 'Click here to support participants',
        thanks_so_much: 'Thank you',
      },
    },
  }

  it('is a Vue instance', () => {
    const wrapper = shallowMount(EmailTemplatesModal, {
      localVue,
      mocks: { $store, $route },

    })
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  it('it renders correctly with 1 participant', () => {
    const wrapper = shallowMount(EmailTemplatesModal, {
      localVue,
      mocks: { $store, $route },
    })
    expect(wrapper.html()).toMatchSnapshot()
  })

  it('it renders correctly with 2 participants', () => {
    $store.state.User.programs[0].participants.push(participant2)
    const wrapper = shallowMount(EmailTemplatesModal, {
      localVue,
      mocks: { $store, $route },
    })
    expect(wrapper.html()).toMatchSnapshot()
  })

  it('it renders correctly with 3 or more participants', () => {
    $store.state.User.programs[0].participants.push(participant3)
    const wrapper = shallowMount(EmailTemplatesModal, {
      localVue,
      mocks: { $store, $route },
    })
    expect(wrapper.html()).toMatchSnapshot()
  })
})
