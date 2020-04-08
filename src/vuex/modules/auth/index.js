import googleAnalyticsMixin from '@/mixins/googleAnalyticsMixin'
import mutateUser from '@/utilities/mutateUser'

export const namespaced = true
export const state = {
  user: null,
  userType: null,
  parentUser: null,
  isBetaUser: false,
  newUserPhoto: '',
  newUserPhotoFile: '',
  photoDirty: false,
  error: null,
}

export const getters = {
  user: state => state.user,

  loggedIn: state => !!state.user,

  prUrl: state => `https://github.com/Boosterthon/titan-dashboard/pull/${state.pr}`,

  avatarPath: state => `https://${state.s3Bucket}.s3.amazonaws.com/${state.avatarPath}`,
}

export const mutations = {
  SET_USER_DATA (state, userData) {
    state.user = userData
    localStorage.setItem('loggedIn', 'true')
  },

  LOGOUT (state) {
    state.user = null
    localStorage.removeItem('loggedIn')
    window.location.reload(true)
  },

  SET_AVATAR_PATH (state, avatarPath) {
    state.avatarPath = avatarPath
  },

  SET_ERROR (state, error) {
    state.error = error
  },

  ADD_CONTACTS (state, contacts) {
    state.contacts = state.contacts.concat(contacts)
  },

  SET_CONTACTS (state, payload) {
    state.contacts = payload
  },

  //
  SET_PARENT_USER (state, parent) {
    state.parentUser = parent
  },

  SET_USER (state, user) {
    state.user = user
  },
  SET_userType (state, type) {
    state.userType = type
  },

  SET_DEFAULT_USER_IMAGE (state, url) {
    state.defaultUserImage = url
  },

  SET_NEW_USER_PHOTO (state, photo) {
    state.newUserPhoto = photo
  },

  SET_NEW_USER_PHOTO_FILE (state, blob) {
    state.newUserPhotoFile = blob
  },

  UPDATE_USER (state, user) {
    state.user = user
  },

  SET_PHOTO_DIRTY (state, bool) {
    state.photoDirty = bool
  },
}

export const actions = {

  async register ({ commit }, credentials) {
    try {
      const { data } = await axios.post('/api/register', credentials)
      const userData = mutateUser(data)
      commit('SET_USER_DATA', userData)
    } catch (error) {
      commit('SET_ERROR', error)
    }
  },

  // register ({ commit }, credentials) {
  //   return axios.post('/api/register', credentials).then(({ data }) => {
  //     const userData = mutateUser(data)
  //     commit('SET_USER_DATA', userData)
  //   })
  // },

  async login ({ commit }) {
    try {
      await axios.get('/sanctum/csrf-cookie')
      await axios.post('/api/login', {
        email: 'victor.tolbert@outlook.com',
        password: 'password',
      })
      const { data } = await axios.get('/api/user')
      const userData = mutateUser(data)
      commit('SET_USER_DATA', userData)
      localStorage.setItem('loggedIn', 'true')
      this.$router.push({ name: 'dashboard' })
    } catch (error) {
      commit('SET_ERROR', error)

      // console.log('error: ', error.response)
      // const key = Object.keys(error.response.data.errors)[0]
      // this.errorMessage = error.response.data.errors[key][0]
    }
  },

  // login: ({ commit }, credentials) => {
  //   return axios.get('/sanctum/csrf-cookie').then(() => {
  //     axios.post('/api/login', {
  //       email: 'victor.tolbert@outlook.com',
  //       password: 'password',
  //     }).then(({ data }) => {
  //       const userData = mutateUser(data)
  //       commit('SET_USER_DATA', userData)
  //       localStorage.setItem('loggedIn', 'true')
  //       this.$router.push({ name: 'dashboard' })
  //     }).catch((error) => {
  //       commit('SET_ERROR', error)
  //       // console.log('error: ', error.response)
  //       // const key = Object.keys(error.response.data.errors)[0]
  //       // this.errorMessage = error.response.data.errors[key][0]
  //     })
  //   })
  // },

  async logout ({ commit }) {
    try {
      await axios.post('/api/logout')
    } catch (error) {
      commit('SET_ERROR', error)
    }
    commit('LOGOUT')
    this.$router.push({ name: 'login' })
    // this.$router.push({ name: 'welcome' })
    // document.location.href = '/'
  },

  async fetchUser ({ commit }) {
    try {
      const { data } = await axios.get('/api/user')
      const userData = mutateUser(data)
      commit('SET_USER_DATA', userData)
    } catch (error) {
      commit('SET_ERROR', error)
    }
  },

  async fetchOauthUrl (ctx, { provider }) {
    const { data } = await axios.post(`/api/oauth/${provider}`)

    return data.url
  },

  //
  setUser: ({ state, commit, getters, dispatch }, user) => {
    const mutatedUser = mutateUser(user)

    if (typeof (mutatedUser.notifications) !== 'undefined') {
      dispatch('setNotifications', mutatedUser.notifications)
    }
    commit('SET_USER', mutatedUser)
  },
  setUserPhoto: ({ state, commit, getters, dispatch }, photo) => {
    commit('SET_NEW_USER_PHOTO', photo)
  },
  setUserPhotoFile: ({ state, commit, getters, dispatch }, blob) => {
    commit('SET_NEW_USER_PHOTO_FILE', blob)
  },
  setAvatarPath ({ state }, avatarPath) {
    state.avatarPath = avatarPath
  },
  updateUser ({ state, commit }, properties) {
    const user = { ...state.user, ...properties }
    commit('UPDATE_USER', user)
  },

  refreshUser: ({ state, commit, getters, dispatch }) => {
    axios.get('/v3/home/dashboard-user').then(response => {
      dispatch('setUser', response.data)
    })
  },
  addPotentialSponsor ({ getters }, contact) {
    const participant = getters.participantForPreviousSponsors
    participant.participant_info.potential_sponsors.push(contact)
  },
  removeContact: ({ state, dispatch, getters }, { contact }) => {
    const requestParameters = {
      email: contact.email,
      participantUserId: getters.participantForPreviousSponsors.participant_info.user_id,
    }
    axios.post('/v3/api/delete-contact', requestParameters)
      .then(() => {
        const participant = getters.participantForPreviousSponsors
        if (contact.isPreviousSponsor) {
          // to delete a previous sponsor we create a deleted potential sponsor for the previous sponsor
          dispatch(
            'addPotentialSponsor',
            {
              first_name: contact.first_name,
              last_name: contact.last_name,
              email: contact.email,
              deleted: 1,
              participant_user_id: participant.participant_info.user_id,
              sponsor_user_id: contact.user.id,
              enrollment: 0,
              day_before_run: 0,
              day_after_run: 0,
              sender_user_id: state.user.id,
              opt_out: 0,
              email_opt_out: [],
            },
          )
        } else {
          participant.participant_info.potential_sponsors.map(potentialSponsor => {
            if (contact.email === potentialSponsor.email) {
              potentialSponsor.deleted = 1
            }
          })
        }
      })
  },

  redirectToPayPledges () {
    googleAnalyticsMixin.methods.gaEvent('Parent Dashboard', 'Pledges', 'Pay Pledges')
    window.location.href = '/v3/tkdashboard?redirect=home/payment'
  },
}

export default {
  namespaced,
  state,
  getters,
  mutations,
  actions,
}
