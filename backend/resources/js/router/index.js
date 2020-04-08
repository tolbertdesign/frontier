import Vue from 'vue'
import VueRouter from 'vue-router'
import AppContainer from '@/layouts/AppContainer'
import NProgress from 'nprogress'
import ParentDashboard from '@/views/ParentDashboard'
import TeacherDashboard from '@/views/TeacherDashboard'
import EditParticipant from '@/views/EditParticipant'
import EditProfile from '@/views/EditProfile'
import EasyEmailer from '@/views/EasyEmailer/EasyEmailer'
import FinishLine from '@/views/FinishLine'
import store from '@/store'

Vue.use(VueRouter)

const routes = [
  {
    path: '/v3/home',
    component: AppContainer,
    children: [
      {
        path: 'dashboard',
        name: 'parent-dashboard',
        component: ParentDashboard,
      },
      {
        path: 'teacher-dashboard',
        name: 'teacher-dashboard',
        component: TeacherDashboard,
      },
      {
        path: 'edit-participant/:id',
        name: 'edit-participant',
        component: EditParticipant,
      },
      {
        path: 'edit-profile',
        name: 'edit-profile',
        component: EditProfile,
      },
      {
        path: 'easy-emailer/:participantUserId',
        name: 'easy-emailer',
        component: EasyEmailer,
      },
      {
        path: 'finish-line/:participantUserId',
        name: 'finish-line',
        component: FinishLine,
      },
    ],
  },

]

const router = new VueRouter({
  mode: 'history',
  forcePageRouteRefresh: false,
  linkActiveClass: 'is-active',
  routes,

  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  },
})

router.beforeEach((routeTo, routeFrom, next) => {
  NProgress.start()
  store.dispatch('setContentGroup', routeTo)

  if (router.options.forcePageRouteRefresh) {
    window.location.href = '/v3/home/dashboard/' + routeTo.path
    router.options.forcePageRouteRefresh = false
  } else {
    next()
  }
})

router.afterEach(() => {
  NProgress.done()
})

export default router
