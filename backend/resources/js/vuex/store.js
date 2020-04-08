import Vue from 'vue'
import Vuex from 'vuex'
import User from './modules/user'

Vue.use(Vuex)

function validateUserHasFullInfo (user) {
  const validFirstName = user.first_name !== null
  const validLastName = user.last_name !== null
  const validEmail = user.email !== null
  const validDob = user.dob !== null
  const validPhone = user.phone !== null
  if (validFirstName &&
        validLastName &&
        validEmail &&
        validDob &&
        validPhone) {
    return true
  }
  return false
}

export default new Vuex.Store({
  state: {
    lang: Object,
    user_type: '',
    default_user_image: String,
  },
  modules: {
    User,
  },
  mutations: {
    SET_LANG (state, lang) {
      state.lang = lang
    },
    SET_USER (state, user) {
      if (user.dob) {
        const [year, month, day] = user.dob.split('-')

        user.year = year
        user.month = month
        user.day = day
      }
      state.User = user
    },
    SET_USER_TYPE (state, type) {
      state.user_type = type
    },
    SET_DEFAULT_USER_IMAGE (state, url) {
      state.default_user_image = url
    },
    SET_USER_PHOTO (state, url) {
      const user = state.User
      user.participants[user.participants.length - 1].photo_url = url
      this.commit('SET_USER', user)
    },
    SET_USER_PHOTO_FILE (state, file) {
      const user = state.User
      user.participants[user.participants.length - 1].photo_file = file
      this.commit('SET_USER', user)
    },
    RESET_USER (state) {
      state.User = {
        first_name: '',
        last_name: '',
        participants: [],
        phone: '',
      }
    },
  },
  getters: {
    getUserType (state) {
      const requireFullInfo = ['parent', 'teacher']
      let isValidUser = true
      if (requireFullInfo.includes(state.user_type)) {
        if (!validateUserHasFullInfo(state.User)) {
          isValidUser = false
        }
      }
      if (isValidUser) {
        return state.user_type
      }
      return 'incompleteProfile'
    },
  },
})
