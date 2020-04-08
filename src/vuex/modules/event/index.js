import EventService from '@/services/EventService'

// With this one line of configuration,
// our Getters, Mutations, and Actions
// now must be addressed using this namespace.
// eg. this.$store.dispatch('event/fetchEvents', { })
// mapGetters('event', ['getEventById'])
// mapActions('event', ['fetchEvent'])
// this.$store.dispatch('setUser', this.user);
// How do I call an Action inside of an Action?
// What if the action I want to call is in another module which is namespaced?
//
export const namespaced = true
export const state = {
  events: [],
  eventsTotal: 0,
  event: {},
}
export const getters = {
  getEventById: state => id => {
    return state.events.find(event => event.id === id)
  },
}
export const mutations = {
  ADD_EVENT (state, event) {
    state.events.push(event)
  },
  SET_EVENTS (state, events) {
    state.events = events
  },
  SET_EVENTS_TOTAL (state, eventsTotal) {
    state.eventsTotal = eventsTotal
  },
  SET_EVENT (state, event) {
    state.event = event
  },
}
export const actions = {
  createEvent ({ commit, dispatch, rootState }, event) {
    // eslint-disable-next-line
    console.log('User creating Event is ' + rootState.auth.user)

    return EventService.postEvent(event).then(() => {
      commit('ADD_EVENT', event)
    })
  },
  fetchEvents ({ commit }, { perPage, page }) {
    EventService.getEvents(perPage, page)
      .then(response => {
        commit('SET_EVENTS_TOTAL', parseInt(response.headers['x-total-count']))
        commit('SET_EVENTS', response.data)
      })
      .catch(error => {
        // eslint-disable-next-line
        console.log('There was an error:', error.response)
      })
  },
  fetchEvent ({ commit, getters }, id) {
    var event = getters.getEventById(id)

    if (event) {
      commit('SET_EVENT', event)
    } else {
      EventService.getEvent(id)
        .then(response => {
          commit('SET_EVENT', response.data)
        })
        .catch(error => {
          // eslint-disable-next-line
          console.log('There was an error:', error.response)
        })
    }
  },
}

export default {
  state,
  getters,
  mutations,
  actions,
}
