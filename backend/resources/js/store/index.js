// https://github.com/Boosterthon/titan-dashboard/pull/631
import Vue from 'vue'
import Vuex from 'vuex'
import router from '@/router'
import mutateUser from '@/utilities/mutateUser'
import FamilyPledging from '@/utilities/FamilyPledging'
import notification from './modules/notification'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    notification,
  },
  state: {
    lang: Object,
    user_type: String,
    default_user_image: String,
    activeTab: 0,
    activeEventName: '',
    s3Bucket: '',
    avatarPath: '',
    contacts: [],
    countries: [],
    states: [],
    newUserPhoto: '',
    newUserPhotoFile: '',
    forcePageRouteRefresh: false,
    photoDirty: false,
    isBetaUser: false,
    contentGroup: '',
    User: {},
  },
  getters: {
    activePrograms: state => {
      return state.User.programs.filter(program => {
        return program.archived === 0 && program.deleted === 0
      })
    },
    avatarPath: state => `https://${state.s3Bucket}.s3.amazonaws.com/${state.avatarPath}`,
    getParticipants: state => state.User.programs.map(program => program.participants).flat(),
    getPrograms: state => state.User.programs,
    programParticipantCount: ({ User: { programs } }) => (programId) => {
      return programs.filter(program => program.id === programId)
        .map(program => program.participants)
        .flat()
        .length
    },
    participants: (state, getters) => {
      return getters.participantProgram.participants
    },
    familyPledges: state => (pledges, program) => {
      if (!pledges[0].family_pledge_id) {
        const participant = program.participants.find(participant => {
          return participant.id === pledges[0].participant_user_id
        })

        return [
          participant.participant_info.pledges.find(pledge => {
            return pledge.id === pledges[0].id
          }),
        ]
      }
      const returnPledges = []
      program.participants.forEach(participant => {
        const pledge = participant.participant_info.pledges.find(pledge => { return pledge.family_pledge_id === pledges[0].family_pledge_id })
        returnPledges.push(pledge)
      })
      return returnPledges
    },
    lang: state => state.lang,
    activeTab: state => state.activeTab,
    teacherParticipant: state => (program) => {
      const teacherParticipantId = state.User.teacher_participant_id
      return program.participants.find(participant => participant.id === teacherParticipantId)
    },
    familyPledgingObj: state => participantId => {
      return new FamilyPledging(state.User.programs, participantId)
    },
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
    participantProgram: (state, getters) => {
      return _.find(state.User.programs, program => {
        return _.find(program.participants, participant => participant.id === getters.participantForPreviousSponsors.id) !== undefined
      })
    },
    getAllParticipantPledges: state => {
      let pledges = []

      state.User.programs.forEach(function (program) {
        program.participants.forEach(function (participant) {
          pledges = pledges.concat(participant.participant_info.pledges)
        })
      })

      return pledges.filter(pledge => {
        return pledge.deleted !== 1
      })
    },
  },
  mutations: {
    SET_LANG (state, lang) {
      state.lang = lang
    },
    SET_PARENT_USER (state, parent) {
      state.ParentUser = parent
    },
    SET_PROGRAMS (state, programs) {
      state.programs = programs
    },
    SET_USER (state, user) {
      state.User = user
    },
    SET_USER_TYPE (state, type) {
      state.user_type = type
    },
    SET_DEFAULT_USER_IMAGE (state, url) {
      state.default_user_image = url
    },
    SET_NEW_USER_PHOTO (state, photo) {
      state.newUserPhoto = photo
    },
    SET_NEW_USER_PHOTO_FILE (state, blob) {
      state.newUserPhotoFile = blob
    },
    SET_S3_BUCKET (state, bucket) {
      state.s3Bucket = bucket
    },
    SET_BETA_BANNER_KILL_SWITCH (state, beta_banner_kill_switch) {
      state.beta_banner_kill_switch = Boolean(beta_banner_kill_switch)
    },
    SET_MIN_PASSWORD_LENGTH (state, length) {
      state.minPasswordLength = length
    },
    SET_AVATAR_PATH (state, avatarPath) {
      state.avatarPath = avatarPath
    },
    SET_CONTACTS (state, contacts) {
      state.contacts = state.contacts.concat(contacts)
    },
    UPDATE_USER ({ User }, properties) {
      User = { ...User, ...properties }
    },
    SET_PHOTO_DIRTY (state, bool) {
      state.photoDirty = bool
    },
    PLEDGE_TYPES (state, pledge_types) {
      state.pledge_types = pledge_types
    },
    SPONSOR_TYPES (state, sponsor_types) {
      state.sponsor_types = sponsor_types
    },
    UPDATE_PLEDGES (state, pledges) {
      pledges.forEach(pledge => {
        state.User.programs.forEach(program => {
          const participant = program.participants.find(participant => {
            return participant.id === pledge.participant_user_id
          })
          if (participant) {
            const index = participant.participant_info.pledges.findIndex(participant_pledge => {
              return participant_pledge.id === pledge.id
            })
            pledge.amount = parseFloat(pledge.amount)
            pledge.participant = pledge.participant_user
            Vue.set(participant.participant_info.pledges, index, pledge)
          }
        })
      })
    },
    DELETE_PLEDGE (state, pledge) {
      const programs = state.User.programs.filter(program => {
        return pledge.program_id === program.id
      })

      programs.forEach(program => {
        program.participants.forEach(participant => {
          for (let i = 0; i < participant.participant_info.pledges.length; i++) {
            const participantPledge = participant.participant_info.pledges[i]

            if ((participantPledge.family_pledge_id !== null && participantPledge.family_pledge_id === pledge.family_pledge_id) || participantPledge.id === pledge.id) {
              participant.participant_info.pledges.splice(i, 1)
            }
          }
        })
      })

      state.User = { ...state.User }
    },
    COUNTRIES (state, countries) {
      state.countries = countries
    },
    STATES (state, states) {
      state.states = states
    },
    SET_CONTENT_GROUP (state, contentGroup) {
      state.contentGroup = contentGroup
    },
    SET_ACTIVE_TAB (state, index) {
      state.activeTab = index
    },
  },
  actions: {
    setUser: ({ state, commit, getters, dispatch }, user) => {
      const mutatedUser = mutateUser(user)
      dispatch('setNotifications', mutatedUser.notifications)
      commit('SET_USER', mutatedUser)
    },
    setUserPhoto: ({ state, commit, getters, dispatch }, photo) => {
      commit('SET_NEW_USER_PHOTO', photo)
    },
    setUserPhotoFile: ({ state, commit, getters, dispatch }, blob) => {
      commit('SET_NEW_USER_PHOTO_FILE', blob)
    },
    setAvatarPath (state, avatarPath) {
      state.avatarPath = avatarPath
    },
    UPDATE_USER (state, properties) {
      state.User = { ...state.User, ...properties }
    },
    refreshUser: ({ state, commit, getters, dispatch }) => {
      axios.get('/v3/home/dashboard-user').then(response => {
        dispatch('setUser', response.data)
      })
    },
    addPotentialSponsor ({ getters }, contact) {
      const participant = getters.participantForPreviousSponsors
      participant.participant_info.potential_sponsors.push(contact)
    },
    removeContact: ({ state, dispatch, getters }, { contact }) => {
      const requestParameters = {
        email: contact.email,
        participantUserId: getters.participantForPreviousSponsors.participant_info.user_id,
      }
      axios.post('/v3/api/delete-contact', requestParameters)
        .then(() => {
          const participant = getters.participantForPreviousSponsors
          if (contact.isPreviousSponsor) {
            // to delete a previous sponsor we create a deleted potential sponsor for the previous sponsor
            dispatch(
              'addPotentialSponsor',
              {
                first_name: contact.first_name,
                last_name: contact.last_name,
                email: contact.email,
                deleted: 1,
                participant_user_id: participant.participant_info.user_id,
                sponsor_user_id: contact.user.id,
                enrollment: 0,
                day_before_run: 0,
                day_after_run: 0,
                sender_user_id: state.User.id,
                opt_out: 0,
                email_opt_out: [],
              },
            )
          } else {
            participant.participant_info.potential_sponsors.map(potentialSponsor => {
              if (contact.email === potentialSponsor.email) {
                potentialSponsor.deleted = 1
              }
            })
          }
        })
    },
    setContentGroup: ({ state, commit }, route) => {
      if (state.contentGroup !== route.name) {
        gtag('config', 'UA-18391724-4', {
          page_title: route.name,
          page_path: route.path,
          content_group1: route.name,
        })
        commit('SET_CONTENT_GROUP', route.name)
      }
    },
    setActiveTab ({ state, commit }, index) {
      commit('SET_ACTIVE_TAB', index)
    },
  },
})

export default store
