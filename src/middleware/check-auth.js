import store from '@/vuex/store'

export default async (to, from, next) => {
  if (!store.getters['auth/check'] && store.getters['auth/token']) {
    try {
      await store.dispatch('auth/fetchUser')
    } catch (e) {
      // eslint-disable-next-line
      console.log(e)
    }
  }

  next()
}
