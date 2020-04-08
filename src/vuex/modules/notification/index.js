export const namespaced = true
const state = {
  TYPE_PROGRAM: 'ProgramAlert',
  notifications: [],
}

const getters = {
  TYPES: state => {
    return [
      state.TYPE_PROGRAM,
    ]
  },
  programNotifications: state => programId => {
    return state.notifications.filter(notification => notification.program_id === programId)
  },
  notificationsOutsideOfProgram: state => programId => {
    return state.notifications.filter(notification => notification.program_id !== programId)
  },
  unReadNotificationsByProgram: (state, getters) => programId => {
    return getters.programNotifications(programId).filter(notification => !getters.isRead(notification))
  },
  unReadNotifications: (state, getters) => {
    return state.notifications.filter(notification => !getters.isRead(notification))
  },
  isRead: state => notification => {
    return notification.read_at !== null
  },
  programHasNotifications: (state, getters) => programId => {
    return getters.programNotifications(programId).length > 0
  },
  sortNotificationsByProgramId: (state, getters) => programId => {
    const programNotifications = getters.programNotifications(programId)
    const otherNotifications = getters.notificationsOutsideOfProgram(programId)

    return programNotifications.concat(otherNotifications)
  },
}

const mutations = {
  SET_NOTIFICATIONS (state, notifications) {
    state.notifications = notifications
  },
}

const actions = {
  readNotification ({ state, commit }, notification) {
    if (notification.read_at === null) {
      const stateNotifications = state.notifications

      stateNotifications.forEach(stateNotification => {
        if (stateNotification.id === notification.id) {
          stateNotification.read_at = new Date()
        }
      })
      this.$axon.update('users/notifications', notification.id, notification, () => {}, () => {})
        .catch(error => {
          // eslint-disable-next-line
          console.log(error)
        })
      commit('SET_NOTIFICATIONS', stateNotifications)
    }
  },
  setNotifications ({ commit }, notifications) {
    commit('SET_NOTIFICATIONS', notifications)
  },
}

export default {
  namespaced,
  state,
  getters,
  mutations,
  actions,
}
