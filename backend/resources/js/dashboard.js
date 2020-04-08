import 'core-js/stable'
import 'regenerator-runtime/runtime'

import axios from 'axios'
import axon from '@/axon'
import Vue from 'vue'
import router from '@/router'
import store from '@/store'
import storeLoader from '@/storeLoader'

import upperFirst from 'lodash/upperFirst'
import camelCase from 'lodash/camelCase'

import '@/plugins'
import '@/components'
import '@/filters'
import '@/mixins'
import '@/utilities'

// Globally Register Base and Layout Components
const requireComponent = require.context(
  './components',
  false,
  /Base[A-Z]\w+\.(vue|js)$/,
)
requireComponent.keys().forEach(fileName => {
  const componentConfig = requireComponent(fileName)
  const componentName = upperFirst(
    camelCase(fileName.replace(/^\.\/(.*)\.\w+$/, '$1')),
  )
  Vue.component(componentName, componentConfig.default || componentConfig)
})

// TODO: Handle initialization in a better way
Vue.component('store-loader', storeLoader)

//
// require('./bootstrap');
require('@/navigation')
require('slick-carousel/slick/slick')

const CarouselCustomizations = require('@/CarouselCustomizations')
const ClickToCopy = require('@/ClickToCopy')
ClickToCopy.enable()
const GoogleAnalytics = require('@/GoogleAnalytics')
const Facebook = require('@/Facebook')

const carouselCustomizations = new CarouselCustomizations()
const googleAnalytics = new GoogleAnalytics()
const facebook = new Facebook()

carouselCustomizations.enable()
googleAnalytics.enable()
facebook.enable()

window.Vue.component('readmore-component', require('@/components/ReadMoreComponent.vue').default)
window.Vue.component('vimeo-thumbnail', require('@/components/VimeoThumbnail.vue').default)
window.Vue.component('level-set', require('@/components/LevelSet.vue').default)
//

if (window.__INITIAL_STATE__) {
  store.replaceState(window.__INITIAL_STATE__)
}

// Don't warn about using the dev version of Vue in development.
Vue.config.productionTip = process.env.NODE_ENV === 'production'

// Make Axon available globally as `this.$axon` in components
Vue.prototype.$axon = window.axon = axon
Vue.prototype.$http = window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.withCredentials = true
window.axios.defaults.baseURL = 'http://ecosystem.test'

const token = document.head.querySelector('meta[name="csrf-token"]')
if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

// eslint-disable-next-line
const vm = new Vue({
  el: '#app',
  store,
  router,
})

require('./slickCustom.js')

// refactor this out
document.cookie = 'hide_cookie_policy=hide;expires= Fri, 31 Dec 9999 23:59:59 GMT'

// // eslint-disable-next-line
// const app = window.Vue = new Vue({
//   i18n,
//   router,
//   store,
//   render: h => h(DashboardApp),
// }).$mount('#app')

// If running inside Cypress...
if (process.env.VUE_APP_TEST === 'e2e') {
  // Attach the app to the window, which can be useful
  // for manually setting state in Cypress commands
  // such as `cy.logIn()`.
  window.__app__ = vm

  // Ensure tests fail when Vue emits an error.
  Vue.config.errorHandler = window.Cypress.cy.onUncaughtException
}
