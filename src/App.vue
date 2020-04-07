<template>
  <div id="app">
    <video controls>
      <source src="http://cominex.net/assets/video/vuex_modules.mp4" type="video/mp4">
    </video>
  </div>
</template>

<script>
import User from '../mock_server'
/**
 * @param {String} language
 *  a language code, typically an ISO 639-[1-3] code.
 * @param {String} messageKey
 *  an identifier for the message, typically a short descriptive text
 * @param {String[]} messageParams
 *  Strings to be substituted into the message using some pattern, e.g., %s or
 *  %1$s, %2$s. By default we only use a simple %s pattern.
 * @returns {String}
 *  the translation to use
 */
export default {
  name: 'App',
  mounted() {
    console.log(User.first_name)
    console.log('NODE_ENV', process.env.NODE_ENV)
    console.log('BASE_URL', process.env.BASE_URL)
    console.log('VUE_APP_TITLE', process.env.VUE_APP_TITLE)
    console.log('VUE_APP_SERVER_URL', process.env.VUE_APP_SERVER_URL)
  }
}
</script>
