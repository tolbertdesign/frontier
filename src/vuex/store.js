import Vue from 'vue'
import Vuex from 'vuex'

import SecureLS from 'secure-ls'
import createPersistedState from 'vuex-persistedstate'
import auth from '@/vuex/modules/auth'
import program from '@/vuex/modules/program'
import participant from '@/vuex/modules/participant'
import pledge from '@/vuex/modules/pledge'
import classroom from '@/vuex/modules/classroom'
import microsite from '@/vuex/modules/microsite'
import notification from '@/vuex/modules/notification'
import * as alert from '@/vuex/modules/alert'
// import easy_emailer from '@/vuex/modules/easy_emailer'

// import event from '@/vuex/modules/event'
// import FamilyPledging from '@/utilities/FamilyPledging'

const ls = new SecureLS({ isCompression: false })

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    program,
    participant,
    pledge,
    classroom,
    microsite,
    notification,
    alert,
    // easy_emailer,
    // event,
  },
  // Enable strict mode in development to get a warning
  // when mutating state outside of a mutation.
  // https://vuex.vuejs.org/guide/strict.html
  strict: process.env.NODE_ENV !== 'production',
  state: {
    config: {
      ua: '',
      env: process.env.NODE_ENV,
    },
    lang: Object,
    s3Bucket: '',
    avatarPath: '',
    defaultUserImage: '',
    minPasswordLength: 0,
    contentGroup: '',
    activeTab: 0,
    activeEventName: '',
    states: [],
    countries: [],
    forcePageRouteRefresh: false,
    photoDirty: false,
    isBetaUser: false,
    error: null,
  },
  getters: {
    lang: state => state.lang,
    activeTab: state => state.activeTab,
    avatarPath: state => `https://${state.s3Bucket}.s3.amazonaws.com/${state.avatarPath}`,
  },
  mutations: {
    SET_LANG (state, lang) {
      state.lang = lang
    },
    SET_S3_BUCKET (state, bucket) {
      state.s3Bucket = bucket
    },
    SET_BETA_BANNER_KILL_SWITCH (state, beta_banner_kill_switch) {
      state.beta_banner_kill_switch = Boolean(beta_banner_kill_switch)
    },
    SET_MIN_PASSWORD_LENGTH (state, length) {
      state.minPasswordLength = length
    },
    SET_AVATAR_PATH (state, avatarPath) {
      state.avatarPath = avatarPath
    },
    SET_CONTENT_GROUP (state, contentGroup) {
      state.contentGroup = contentGroup
    },
    SET_ACTIVE_TAB (state, index) {
      state.activeTab = index
    },
    SET_STATES (state, states) {
      state.states = states
    },
    SET_COUNTRIES (state, countries) {
      state.countries = countries
    },
  },
  actions: {
    init: ({ dispatch }, user) => {
      dispatch('participant/initParticipantsAndPledges', user.participants)
      dispatch('program/initPrograms')
      dispatch('classroom/initClassrooms')
    },
    setContentGroup: ({ state, commit }, route) => {
      if (state.contentGroup !== route.name) {
        gtag('config', 'UA-18391724-4', {
          page_title: route.name,
          page_path: route.path,
          content_group1: route.name,
        })
        commit('SET_CONTENT_GROUP', route.name)
      }
    },
    setActiveTab: ({ commit }, index) => {
      commit('SET_ACTIVE_TAB', index)
    },
  },

  plugins: [
    createPersistedState({
      storage: {
        getItem: key => ls.get(key),
        setItem: (key, value) => ls.set(key, value),
        removeItem: key => ls.remove(key),
      },
    }),
  ],
})

export default store
