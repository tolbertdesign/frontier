const state = {
  participants: [],
}

const getters = {
  getParticipant: state => id => {
    return state.participants.filter(participant => participant.id === id)
  },
}

const mutations = {
  SET_PARTICIPANTS (state, participants) {
    state.participants = participants
  },
}

const actions = {
  setParticipants: ({ commit }, participants) => {
    commit('SET_PARTICIPANTS', participants)
  },
}

export default {
  state,
  getters,
  actions,
  mutations,
}
