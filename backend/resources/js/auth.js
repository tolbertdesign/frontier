import 'core-js/stable'
import 'regenerator-runtime/runtime'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import store from '@/store'
import Croppa from 'vue-croppa'
import VueConfetti from 'vue-confetti'
import VueTheMask from 'vue-the-mask'
import Snowf from 'vue-snowf'
// import AuthApp from '@/AuthApp'

Vue.use(Croppa)
Vue.use(VueConfetti)
Vue.use(VueTheMask)

window._ = require('lodash')

window.Popper = require('popper.js').default

try {
  window.$ = window.jQuery = require('jquery')
  require('bootstrap')
} catch (e) {
  // eslint-disable-next-line
  console.log(e)
}

window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token')
}

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Standard inputs
Vue.component('text-input', require('@/components/inputs/Text.vue').default)
Vue.component('selection-input', require('@/components/inputs/Selection.vue').default)
Vue.component('toggle-input', require('@/components/inputs/Toggle.vue').default)

// Standard Buttons
Vue.component('back', require('@/components/buttons/Back.vue').default)
Vue.component('google-login', require('@/components/buttons/GoogleLogin.vue').default)

Vue.component('carousel-component', require('@/components/CarouselComponent.vue').default)
Vue.component('login-fields', require('@/components/LoginFields.vue').default)
Vue.component('password-reset-fields', require('@/components/PasswordResetFields.vue').default)
Vue.component('progress-bar', require('@/components/ProgressBar.vue').default)

Vue.component('welcome', require('@/components/registration/Welcome.vue').default)
Vue.component('sign-up', require('@/components/registration/SignUp.vue').default)
Vue.component('welcome-back', require('@/components/registration/WelcomeBack').default)
Vue.component('registration-form', require('@/components/registration/RegistrationForm.vue').default)
Vue.component('registration-type', require('@/components/registration/RegistrationType.vue').default)
Vue.component('school-search', require('@/components/registration/SchoolSearch.vue').default)
Vue.component('participant-form', require('@/components/registration/ParticipantForm.vue').default)
Vue.component('participant-register-success', require('@/components/registration/ParticipantRegisterSuccess.vue').default)
Vue.component('registration-handler', require('@/components/registration/RegistrationHandler.vue').default)
Vue.component('welcome-teachers', require('@/components/registration/WelcomeTeachers.vue').default)
Vue.component('upload-photo-form', require('@/components/registration/UploadPhotoForm/UploadPhotoForm.vue').default)
Vue.component('Snowf', Snowf)

// eslint-disable-next-line
const app = new Vue({
  el: '#app',
  store,
})

$(document).ready(function () {
  var trigger = $('.hamburger')
  var overlay = $('.overlay')
  var isClosed = false

  trigger.click(function () {
    hamburgerCross()
  })

  function hamburgerCross () {
    if (isClosed === true) {
      overlay.hide()
      trigger.removeClass('is-open')
      trigger.addClass('is-closed')
      isClosed = false
    } else {
      overlay.show()
      trigger.removeClass('is-closed')
      trigger.addClass('is-open')
      isClosed = true
    }
  }

  $('[data-toggle="offcanvas"]').click(function () {
    $('#wrapper').toggleClass('toggled')
  })

  $('.copy-text').tooltip({ trigger: 'manual' })
  $('.copy-text').on('click', function () {
    var that = this
    that.select()
    document.execCommand('Copy')
    $(that).tooltip('show')
    setTimeout(function () {
      $(that).tooltip('hide')
    }, 1000)
  })
})

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
