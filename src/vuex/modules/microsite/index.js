export const namespaced = true

const state = () => ({
  microsite: {},
})

const getters = {
  micrositeByProgramId: getters => programId => {
    return getters.programs.find(program => program.id === programId).microsite
  },
}

const mutations = {}

const actions = {}

export default {
  state,
  getters,
  mutations,
  actions,
}
