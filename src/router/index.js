import Vue from 'vue'
import Router from 'vue-router'
// Adds a loading bar at the top during page loads.
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'

// https://github.com/declandewet/vue-meta
import Meta from 'vue-meta'
import { sync } from 'vuex-router-sync'
import routes from '@/router/routes'
import store from '@/vuex/store'

Vue.use(Router)
Vue.use(Meta, {
  // The component option name that vue-meta looks for meta info on.
  keyName: 'page',
})

const router = new Router({
  routes,
  base: process.env.BASE_URL,
  // Use the HTML5 history API (i.e. normal-looking routes)
  // instead of routes with hashes (e.g. example.com/#/about).
  // This may require some server configuration in production:
  // https://router.vuejs.org/en/essentials/history-mode.html#example-server-configurations
  mode: 'history',
  // Simulate native-like scroll behavior when navigating to a new
  // route and using back/forward buttons.
  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  },
})

router.beforeEach((routeTo, routeFrom, next) => {
  // If this isn't an initial page load...
  if (routeFrom.name !== null) {
    // Start the route progress bar.
    NProgress.start()
  }

  if (routeTo.matched.some(record => record.meta.requiresAuth)) {
    if (!isLoggedIn()) {
      next({
        name: 'home',
      })
    } else {
      next()
    }
  } else if (routeTo.matched.some(record => record.meta.requiresVisitor)) {
    if (isLoggedIn()) {
      next({
        name: 'dashboard',
      })
    } else {
      next()
    }
  } else {
    next() // make sure to always call next()!
  }

  // If auth is required and the user is NOT currently logged in,
  // redirect to login.
  // redirectToLogin()

  // function redirectToLogin () {
  //   // Pass the original route to the login component
  //   next({ name: 'login', query: { redirectFrom: routeTo.fullPath } })
  // }
})

router.afterEach(() => {
  NProgress.done()
})

function isLoggedIn () {
  return store.getters['auth/loggedIn']
}

sync(store, router)

export default router
