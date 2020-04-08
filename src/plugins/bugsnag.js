import Vue from 'vue'
import bugsnag from '@bugsnag/js'
import bugsnagVue from '@bugsnag/plugin-vue'

const bugsnagClient = bugsnag('1e5d2fff1841daf1fa3fbb52cd1d393e')
bugsnagClient.use(bugsnagVue, Vue)
window.bugsnagClient = bugsnagClient
