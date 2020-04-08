import FamilyPledging from '@/utilities/FamilyPledging'
import router from '@/router'

// With this one line of configuration,
// our Getters, Mutations, and Actions
// now must be addressed using this namespace.
// eg. this.$store.dispatch('event/fetchEvents', { })
// mapGetters('event', ['getEventById'])
// mapActions('event', ['fetchEvent'])
// How do I call an Action inside of an Action?
// What if the action I want to call is in another module which is namespaced?
// 'participants',
// 'participantProgram',
export const namespaced = true
export const state = {
  contacts: [],
}

export const getters = {
  participantForPreviousSponsors: (state, getters) => {
    let participantId = parseInt(router.currentRoute.params.participantUserId)
    if (typeof participantId === 'undefined' || participantId === null || isNaN(participantId)) {
      // Default to the first participant a parent has.
      participantId = getters
        .activePrograms[getters.activeTab]
        .participants
        .reduce((min, current) => min.id < current.id ? min : current)
        .id
    }
    const familyPledgingObj = getters.familyPledgingObj(participantId)

    if (familyPledgingObj.isFamilyPledgingEnabled() && familyPledgingObj.getSmallestIdParticipantInCurrentParticipantProgram()) {
      return familyPledgingObj.getSmallestIdParticipantInCurrentParticipantProgram()
    } else if (familyPledgingObj.getCurrentParticipant()) {
      return familyPledgingObj.getCurrentParticipant()
    } else {
      return null
    }
  },
  getCurrentSponsorEmails: (state, getters) => {
    const pledges = getters.getAllParticipantPledges
    const currentSponsorEmails = []
    var participantProgram = getters.participantProgram
    pledges.forEach(pledge => {
      const isCurrentSponsor = pledge.program_id === participantProgram.id && pledge.participant_user_id === getters.participantForPreviousSponsors.participant_info.user_id

      if (isCurrentSponsor) {
        currentSponsorEmails.push(pledge.pledge_sponsor.email)
      }
    })

    return currentSponsorEmails
  },
  getPreviousSponsors: (state, getters) => {
    let pledges = getters.getAllParticipantPledges
    var participantProgram = getters.participantProgram
    const currentSponsorEmails = getters.getCurrentSponsorEmails

    // Filter out previous sponsors who are not also current sponsors
    pledges = pledges.filter(pledge => {
      const isCurrentSponsor = pledge.program_id === participantProgram.id && pledge.participant_user_id === getters.participantForPreviousSponsors.participant_info.user_id

      return !isCurrentSponsor && currentSponsorEmails.indexOf(pledge.pledge_sponsor.email) === -1
    })

    return pledges.map(pledge => {
      let optOut

      if (pledge.pledge_sponsor.user && pledge.pledge_sponsor.user.id) {
        optOut = pledge.pledge_sponsor.email_opt_out.length > 0 || pledge.pledge_sponsor.user.email_opt_out
      } else {
        optOut = pledge.pledge_sponsor.email_opt_out.length > 0
      }

      return {
        ...pledge.pledge_sponsor,
        isSelected: true,
        isPreviousSponsor: true,
        optOut: optOut,
      }
    })
  },
  familyPledgingObj: state => participantId => {
    return new FamilyPledging(state.auth.user.programs, participantId)
  },
}

export const mutations = {
  SET_CONTACTS (state, contacts) {
    state.contacts = state.contacts.concat(contacts)
  },
}

export default {
  getters,
  mutations,
}
