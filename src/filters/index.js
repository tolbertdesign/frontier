import Vue from 'vue'

import timeAgo from '@/filters/timeAgo'
import host from '@/filters/host'

Vue.filter('timeAgo', timeAgo)
Vue.filter('host', host)
