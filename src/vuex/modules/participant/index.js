export const namespaced = true

const state = () => ({
  participants: [],
})

const getters = {

  participants: state => state.participants,

  // Is this necessary now?
  // getParticipants: state => state.user.programs.map(program => program.participants).flat(),

  participantById: state => id => {
    return state.participants.find(participant => participant.id === id)
  },
  lastParticipant: state => state.participants.slice(-1)[0],

  participantsByProgramId: state => programId => {
    return state.participants.filter(participant => participant.participant_info.classroom.group.program.id === programId)
  },

  otherParticipants: getters => participantId => {
    return getters.participants.filter(otherParticipant => {
      return otherParticipant.id !== participantId
    })
  },
  teacherParticipant: state => (program) => {
    const teacherParticipantId = state.user.teacher_participant_id
    return program.participants.find(participant => participant.id === teacherParticipantId)
  },

  smallestIdParticipant: getters => participant => {
    const program = participant.participant_info.classroom.group.program
    const participantsInProgram = getters.participants.filter(participant => {
      return participant.participant_info.classroom.grade.program !== program.id
    })

    participantsInProgram.sort((a, b) => (a.id > b.id) ? 1 : -1)

    return participantsInProgram[0]
  },

}

const mutations = {
  SET_PARTICIPANTS: (state, participants) => {
    state.participants = participants
  },
}

const actions = {
  initParticipantsAndPledges: ({ getters, commit, rootGetters }, participants) => {
    const allPledges = []

    participants.forEach(participant => {
      const otherParticipants = participants.filter(otherParticipant => {
        return otherParticipant.id !== participant.id
      })

      let pledges = rootGetters['pledge/addFamilyPledgesToPledges'](participant, otherParticipants)
      pledges = rootGetters['pledge/sortPledgesByDateEntered'](pledges)

      participant.participant_info.pledges = pledges
      allPledges.push(pledges)
    })
    // console.log('allPledges flat?: ', allPledges.flat());

    participants = _.sortBy(participants, 'first_name')

    commit('SET_PARTICIPANTS', participants)

    commit('pledge/SET_PLEDGES', allPledges, { root: true })
  },
}

export default {
  namespaced,
  state,
  getters,
  mutations,
  actions,
}
