import store from '@/vuex/store'

export default [
  {
    path: '/',
    name: 'welcome',
    component: () => import(/* webpackChunkName: "welcome" */ '@/pages/welcome'),
    meta: {
      layout: 'FullScreen',
      requiresVisitor: true,
    },
  },
  {
    path: '/login',
    name: 'login',
    component: () => import(/* webpackChunkName: "login" */ '@/pages/login'),
    meta: {
      layout: 'FullScreen',
      requiresVisitor: true,
    },
  },
  {
    path: '/register',
    name: 'register',
    component: () => import(/* webpackChunkName: "register" */ '@/pages/register'),
    meta: {
      layout: 'FullScreen',
      requiresVisitor: true,
    },
  },
  {
    path: '/buy',
    name: 'buy',
    component: () => import(/* webpackChunkName: "buy" */ '@/pages/buy'),
    meta: {
      layout: 'FlexboxApp',
    },
  },
  {
    path: '/contact',
    name: 'contact',
    component: () => import(/* webpackChunkName: "contact" */ '@/pages/contact'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: () => import(/* webpackChunkName: "dashboard" */ '@/pages/dashboard'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/landing',
    name: 'landing',
    component: () => import(/* webpackChunkName: "landing" */ '@/pages/landing'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/templates',
    name: 'templates',
    component: () => import(/* webpackChunkName: "templates" */ '@/pages/templates'),
    meta: {
      layout: 'Sidebar',
      requiresAuth: true,
    },
  },
  {
    path: '/documents',
    name: 'documents',
    component: () => import(/* webpackChunkName: "documents" */ '@/pages/documents'),
    meta: {
      layout: 'Sidebar',
      requiresAuth: true,
    },
  },
  {
    path: '/reports',
    name: 'reports',
    component: () => import(/* webpackChunkName: "reports" */ '@/pages/reports'),
    meta: {
      layout: 'Sidebar',
      requiresAuth: true,
    },
  },
  {
    path: '/profile',
    name: 'profile',
    component: () => import(/* webpackChunkName: "edit-profile" */ '@/pages/profile'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/settings',
    name: 'settings',
    component: () => import(/* webpackChunkName: "settings" */ '@/pages/settings'),
    meta: {
      requiresAuth: true,
    },
  },
  {
    path: '/event/list',
    name: 'event-list',
    component: () => import(/* webpackChunkName: "event-list" */ '@/pages/event-list'),
    props: true,
  },
  {
    path: '/event/create',
    name: 'event-create',
    component: () => import(/* webpackChunkName: "event-create" */ '@/pages/event-create'),
  },
  {
    path: '/event/:id',
    name: 'event-show',
    component: () => import(/* webpackChunkName: "event-show" */ '@/pages/event-show'),
    props: true,
    beforeEnter (routeTo, routeFrom, next) {
      store
        .dispatch('event/fetchEvent', routeTo.params.id)
        .then(event => {
          routeTo.params.event = event
          next()
        })
        .catch(error => {
          if (error.response && error.response.status == 404) {
            next({ name: '404', params: { resource: 'event' } })
          } else {
            next({ name: 'network-issue' })
          }
        })
    },
  },
  {
    path: '/user/:id',
    component: () => import(/* webpackChunkName: "user" */ '@/pages/user'),

  },
  {
    path: '/404',
    name: '404',
    component: () => import(/* webpackChunkName: "not-found" */ '@/pages/not-found'),
  },
  {
    path: '/network-issue',
    name: 'network-issue',
    component: () => import(/* webpackChunkName: "network-issue" */ '@/pages/network-issue'),
  },
  {
    path: '*',
    redirect: {
      name: '404',
      params: {
        resource: 'page',
      },
    },
  },
]
