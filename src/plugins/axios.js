import Vue from 'vue'
import axios from 'axios'
import Swal from 'sweetalert2'
import store from '@/vuex/store'
import router from '@/router'
import i18n from '@/plugins/i18n'

const baseURL = 'http://tolbert.test'

const instance = axios.create({
  baseURL: baseURL,
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
  },
})
instance.defaults.withCredentials = true

// Request interceptor
instance.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    request.headers.common.Authorization = `Bearer ${token}`
  }

  const locale = store.getters['lang/locale']
  if (locale) {
    request.headers.common['Accept-Language'] = locale
  }

  // request.headers['X-Socket-Id'] = Echo.socketId()

  return request
})

// Response interceptor
instance.interceptors.response.use(response => response, error => {
  const { status } = error.response

  if (status >= 500) {
    Swal.fire({
      type: 'error',
      title: i18n.t('error_alert_title'),
      text: i18n.t('error_alert_text'),
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel'),
    })
  }

  if (status === 401 && store.getters['auth/check']) {
    Swal.fire({
      type: 'warning',
      title: i18n.t('token_expired_alert_title'),
      text: i18n.t('token_expired_alert_text'),
      reverseButtons: true,
      confirmButtonText: i18n.t('ok'),
      cancelButtonText: i18n.t('cancel'),
    }).then(() => {
      store.commit('auth/LOGOUT')

      router.push({ name: 'login' })
    })
  }

  return Promise.reject(error)
})

Vue.use({
  install (Vue) {
    Vue.prototype.$http = instance
  },
})

export default instance
