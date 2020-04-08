import Vue from 'vue'
import { camelCase, upperFirst } from 'lodash'
import { HasError, AlertError, AlertSuccess } from 'vform'
import AppLogo from '@/components/AppLogo'
// import ProgressBar from '@/components/ProgressBar'

// Components that are registered globaly.
// [AppLogo].forEach(Component => {
[AppLogo, HasError, AlertError, AlertSuccess].forEach(Component => {
  Vue.component(Component.name, Component)
})

const requireComponent = require.context(
  '@/components',
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

// global progress bar
// const bar = Vue.prototype.$bar = new Vue(ProgressBar).$mount()
// document.body.appendChild(bar.$el)
