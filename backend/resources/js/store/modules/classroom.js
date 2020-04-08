const state = {
  classrooms: [],
  name: '',
  grade: '',
}

const getters = {
  getClassroom: state => id => {
    return state.classrooms.filter(classroom => classroom.id === id)
  },
}

const mutations = {
  SET_CLASSROOMS (state, classrooms) {
    state.classrooms = classrooms
  },
}

const actions = {
  setClassrooms: ({ commit }, classrooms) => {
    commit('SET_CLASSROOMS', classrooms)
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
