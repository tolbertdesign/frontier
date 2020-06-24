export default {
  srcDir: __dirname,
  target: 'static',
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
  tailwindcss: {
    configPath: '~/tailwind.config.js',
    cssPath: '~/assets/css/tailwind.css',
    exposeConfig: true,
  },
  build: {
    postcss: {
      preset: {
        features: {
          // Fixes: https://github.com/tailwindcss/tailwindcss/issues/1190#issuecomment-546621554
          'focus-within-pseudo-class': false,
        },
      },
    },
  },
  buildModules: ['@nuxtjs/svg', '@nuxtjs/tailwindcss'],
  components: true,
  css: ['~/assets/css/tailwind.css'],
}
