import Vue from 'vue'

export default {
  state: {
    first_name: '',
    last_name: '',
    email: '',
    dob: '',
    phone: '',
    participants: [],
  },
  mutations: {
    new_participant (state, school) {
      if (state.participants === undefined) {
        state.participants = []
      }
      if (state.participants.length === 0 || state.participants[state.participants.length - 1].first_name !== '') {
        const newParticipantIndex = state.participants.length
        state.participants[newParticipantIndex] = {
          first_name: '',
          last_name: '',
          school,
          classroom: null,
          photo_url: undefined,
        }
      } else {
        state.participants[state.participants.length - 1].school = school
      }
    },
    update_participant (state, participant) {
      if (state.participants[participant.index].school) {
        participant.data.school = state.participants[participant.index].school
      }
      Vue.set(state.participants, participant.index, participant.data)
    },
  },
  getters: {
    hasParticipants (state) {
      return (
        state.participants[state.participants.length - 1] &&
                state.participants[state.participants.length - 1].first_name !== undefined
      )
    },
  },
}
