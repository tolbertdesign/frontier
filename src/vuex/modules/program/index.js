import { sortBy } from 'lodash'

export const namespaced = true
const state = () => ({
  programs: [],
})

const getters = {
  programs: state => state.programs,

  getPrograms: state => state.programs,

  activePrograms: (state, getters, rootState) => {
    return getters.programs.filter(program => {
      return program.archived === 0 && program.deleted === 0
    })
  },

  program: state => id => {
    return state.programs.find(program => program.id === id)
  },

  programByParticipant: () => participant => {
    return participant.participant_info.classroom.group.program
  },

  participantsInProgram: getters => programId => {
    return getters.participants.filter(participant => {
      return participant.participant_info.classroom.group.program === programId
    })
  },
  // FIXME  Migrate from rootState
  // programParticipantCount: ({ user: { programs } }) => (programId) => {
  //     return programs.filter(program => program.id === programId)
  //         .map(program => program.participants)
  //         .flat()
  //         .length;
  // }
}

const mutations = {
  SET_PROGRAMS: (state, programs) => {
    state.programs = programs
  },
}

const actions = {
  initPrograms: ({ commit, rootGetters }) => {
    const programs = []
    console.log('participant/participants: ', rootGetters['participant/participants'])

    rootGetters['participant/participants'].forEach(participant => {
      const programId = participant.participant_info.classroom.group.program_id

      let program = programs.find(program => program.id === programId)

      if (program === undefined || !participant.participant_info.family_pledging_enabled) {
        program = participant.participant_info.classroom.group.program
        programs.push(program)
      }
    })

    sortBy(programs, 'name')

    commit('SET_PROGRAMS', programs)
  },
}

export default {
  namespaced,
  state,
  getters,
  mutations,
  actions,
}
