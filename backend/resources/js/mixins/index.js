import Vue from 'vue'
import googleAnalytics from './googleAnalytics'
import parseLanguage from './parseLanguage'
import participantDisplayNames from './participantDisplayNames'
import title from './title'

Vue.mixin(googleAnalytics)
Vue.mixin(parseLanguage)
Vue.mixin(participantDisplayNames)
Vue.mixin(title)
