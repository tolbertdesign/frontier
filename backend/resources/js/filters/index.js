// Global Filters
import Vue from 'vue'

import currency from './currency'
import date from './date'
import dollar from './dollar'
import host from './host'
import timeAgo from './timeAgo'
import zeroFill from './zeroFill'

Vue.filter('currency', currency)
Vue.filter('date', date)
Vue.filter('dollar', dollar)
Vue.filter('host', host)
Vue.filter('timeAgo', timeAgo)
Vue.filter('zeroFill', zeroFill)
