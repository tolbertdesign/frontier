const state = {
  schools: [],
}

const getters = {
  getSchool: state => id => {
    return state.schools.filter(school => school.id === id)
  },
}

const mutations = {
  SET_SCHOOLS (state, schools) {
    state.schools = schools
  },
}

const actions = {
  setSchools: ({ commit }, schools) => {
    commit('SET_SCHOOLS', schools)
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
