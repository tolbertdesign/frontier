import Vue from 'vue'
import App from '@/App'

import i18n from '@/plugins/i18n' // $t
import router from '@/router' // $router
import store from '@/vuex/store' // $store

// Globally registration
import '@/components'
import '@/directives'
import '@/filters'
import '@/helpers'
import '@/mixins'
import '@/plugins'
import '@/registerServiceWorker'
// end Global registration

// Layout Components
import DefaultLayout from '@/layouts/DefaultLayout'
import FullScreenLayout from '@/layouts/FullScreenLayout'
import SidebarLayout from '@/layouts/SidebarLayout'
import FlexboxAppLayout from '@/layouts/FlexboxAppLayout'
Vue.component('DefaultLayout', DefaultLayout)
Vue.component('FlexboxAppLayout', FlexboxAppLayout)
Vue.component('FullScreenLayout', FullScreenLayout)
Vue.component('SidebarLayout', SidebarLayout)
// end Layout Components

// Axios ($http or $axios)
window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.withCredentials = true
window.axios.defaults.baseURL = process.env.VUE_APP_SERVER_URL
// end Axios

// If running inside Cypress...
if (process.env.VUE_APP_TEST === 'e2e') {
  // Ensure tests fail when Vue emits an error.
  Vue.config.errorHandler = window.Cypress.cy.onUncaughtException
}

Vue.config.productionTip = process.env.NODE_ENV === 'production'

const app = new Vue({
  i18n,
  router,
  store,
  render: h => h(App),
}).$mount('#app')

// If running e2e tests...
if (process.env.VUE_APP_TEST === 'e2e') {
  // Attach the app to the window, which can be useful
  // for manually setting state in Cypress commands
  // such as `cy.logIn()`.
  window.__app__ = app
}
