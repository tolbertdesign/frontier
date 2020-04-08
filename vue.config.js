const appConfig = require('./src/app.config')

/** @type import('@vue/cli-service').ProjectOptions */
module.exports = {
  devServer: {
    host: 'app.tolbert.test',
    open: 'Google Chrome',
  },
  pluginOptions: {
    i18n: {
      locale: 'en',
      fallbackLocale: 'en',
      localeDir: 'locales',
      enableInSFC: false,
    },
    webpackBundleAnalyzer: {
      openAnalyzer: true,
    },
  },
  chainWebpack (config) {
    config.set('name', appConfig.title)
  },
}
