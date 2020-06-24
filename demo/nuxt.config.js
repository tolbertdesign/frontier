export default {
  srcDir: __dirname,
  modules: ['@nuxtjs/auth', '@nuxtjs/axios', '@nuxtjs/pwa', 'nuxt-buefy'],
  auth: {
    redirect: {
      login: '/login',
      logout: '/',
      callback: '/login',
      home: '/',
    },
    strategies: {
      local: {
        autoFetchUser: false,
        endpoints: {
          login: {url: '/login', method: 'post', propertyName: false},
          user: {url: '/api/user', method: 'get', propertyName: false},
        },
        tokenRequired: false,
        tokenType: false,
      },
    },
    localStorage: false,
  },
  axios: {
    baseURL: 'http://tolbert.test',
    credentials: true,
  },
  buefy: {
    css: true,
    materialDesignIcons: true,
  },
  buildModules: ['@nuxtjs/svg', '@nuxtjs/tailwindcss'],
  components: true,
}
