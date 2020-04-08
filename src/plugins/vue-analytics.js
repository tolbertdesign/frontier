import Vue from 'vue'
import VueAnalytics from 'vue-analytics'
import router from '@/router'

Vue.use(VueAnalytics, {
  id: 'UA-76464598-2',
  router,
})
