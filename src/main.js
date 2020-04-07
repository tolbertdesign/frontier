import Vue from 'vue'
import App from '@/App'

Vue.config.productionTip = false

new Vue({
  render: function (h) { return h(App) },
}).$mount('#app')
