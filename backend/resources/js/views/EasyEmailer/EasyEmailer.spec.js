import { shallowMount, createLocalVue } from '@vue/test-utils'
import EasyEmailer from './EasyEmailer.vue'
import ParentSeeder from '@/seed/parent.json'
import mutateUser from '@/utilities/mutateUser'
import { PledgingStatus } from '@/utilities/PledgingStatus'
import ParticipantDisplayNames from '@/mixins/ParticipantDisplayNames'
import LanguageParser from '@/mixins/LanguageParser'

const localVue = createLocalVue()
localVue.mixin(ParticipantDisplayNames)
localVue.mixin(LanguageParser)

describe('EasyEmailer', () => {
  const parent = mutateUser(ParentSeeder)

  // Set up an opted out sponsor created by the parent user
  const participantUserId = 5
  // Make sure we have a non-deleted potential sponsor
  parent.programs[0].participants[0].participant_info.potential_sponsors[0].deleted = 0
  const optedOutSponsor = parent.programs[0].participants[0].participant_info.potential_sponsors.filter(
    sponsor => sponsor.deleted === 0,
  ).filter(
    sponsor => sponsor.participant_user_id === participantUserId,
  )
  optedOutSponsor[0].sender_user_id = parent.id
  optedOutSponsor[0].opt_out = 1

  const $store = {
    state: {
      lang: {
        easy_emailer: 'Easy Emailer',
        add_contacts_to_send_emails: 'add_contacts_to_send_emails',
        view_emails_here: 'view_emails_here',
        send_your_own_email_intro: 'send_your_own_email_intro',
        pre_written_template: 'pre_written_template',
        email_template_student_star_subject: 'email_template_student_star_subject',
        email_template_subject: 'email_template_subject',
        student_star_email_template: 'student_star_email_template',
        email_template: 'email_template',
        for: 'for',
        email_template_ppl_expectation: 'email_template_ppl_expectation',
        email_template_flat_expectation: 'email_template_flat_expectation',
      },
      User: parent,
    },
    getters: {
      participantProgram: parent.programs[0],
      participants: parent.programs[0].participants,
      participantForPreviousSponsors: parent.programs[0].participants[0],
      getCurrentSponsorEmails: ['test@test.com'],
      getPreviousSponsors: [],
    },
  }

  const $route = {
    params: {
      participantUserId: 5,
    },
  }

  it('is a Vue instance', () => {
    const wrapper = shallowMount(EasyEmailer, {
      mocks: { $store, $route },
      propsData: { EMAIL: 3, EMAIL_VIDEO: 10 },
      localVue,
    })
    expect(wrapper.isVueInstance()).toBeTruthy()
  })

  it('calculates opted out status as unsubscribed', () => {
    const wrapper = shallowMount(EasyEmailer, {
      mocks: { $store, $route },
      propsData: { EMAIL: 3, EMAIL_VIDEO: 10 },
      localVue,
    })
    const contacts = wrapper.vm.getContacts
    const optedOutContact = contacts.find(contact => contact.id === optedOutSponsor[0].id)
    expect(optedOutContact.status).toBe(PledgingStatus.UNSUBSCRIBED)
  })
})
