import Cookies from 'js-cookie'

const { locale, locales } = window.config

export const state = {
  locale: Cookies.get('locale') || locale,
  locales: locales,
}

export const getters = {
  locale: state => state.locale,
  locales: state => state.locales,
}

export const mutations = {
  SET_LOCALE (state, { locale }) {
    state.locale = locale
  },
}

export const actions = {
  setLocale ({ commit }, { locale }) {
    commit('SET_LOCALE', { locale })

    Cookies.set('locale', locale, { expires: 365 })
  },
}
