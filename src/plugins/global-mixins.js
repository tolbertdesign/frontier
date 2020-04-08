import Vue from 'vue'

import LanguageParser from '@/mixins/LanguageParser'
import ParticipantDisplayNames from '@/mixins/ParticipantDisplayNames'
import googleAnalyticsMixin from '@/mixins/googleAnalyticsMixin'

Vue.mixin(LanguageParser)
Vue.mixin(ParticipantDisplayNames)
Vue.mixin(googleAnalyticsMixin)
