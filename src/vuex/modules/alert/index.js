export const namespaced = true

export const state = {
  alerts: [],
}

let nextId = 1

export const mutations = {
  PUSH (state, alert) {
    state.alerts.push({
      ...alert,
      id: nextId++,
    })
  },
  DELETE (state, alertToRemove) {
    state.alerts = state.alerts.filter(
      alert => alert.id !== alertToRemove.id,
    )
  },
}
export const actions = {
  add ({ commit }, alert) {
    commit('PUSH', alert)
  },
  remove ({ commit }, alertToRemove) {
    commit('DELETE', alertToRemove)
  },
}

export default {
  state,
  mutations,
  actions,
}
