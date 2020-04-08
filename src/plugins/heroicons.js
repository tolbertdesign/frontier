import Vue from 'vue'

import * as outline from '@/icons/heroicons/outline'
import * as solid from '@/icons/heroicons/solid'

Object.values(solid).forEach(icon => {
  Vue.component(`Solid${icon.name}`, icon)
})

Object.values(outline).forEach(icon => {
  Vue.component(`Outline${icon.name}`, icon)
})
