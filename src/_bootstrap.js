import '@/components'

import '@/plugins/alert'
import '@/plugins/axios'
import '@/plugins/gravatar'
import '@/plugins/heroicons'
import '@/plugins/portal-vue'
import '@/plugins/tooltips'
import '@/plugins/validation'
import '@/plugins/vue-clipboard2'
import '@/plugins/vue-composition-api'
import '@/plugins/vue-fuse'
import '@/plugins/vuelidate'

import '@/utilities'

// import '@fortawesome/fontawesome-free/css/all.min.css'

Promise.delay = function (time) {
  return new Promise((resolve) => {
    setTimeout(resolve, time)
  })
}

Promise.prototype.takeAtLeast = function (time) {
  return new Promise((resolve, reject) => {
    Promise.all([this, Promise.delay(time)]).then(([result]) => {
      resolve(result)
    }, reject)
  })
}
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//   broadcaster: "pusher",
//   cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//   encrypted: true,
//   key: process.env.MIX_PUSHER_APP_KEY,
//   authorizer: (channel, options) => {
//       return {
//           authorize: (socketId, callback) => {
//               axios.post('/api/broadcasting/auth', {
//                   socket_id: socketId,
//                   channel_name: channel.name
//               })
//               .then(response => {
//                   callback(false, response.data);
//               })
//               .catch(error => {
//                   callback(true, error);
//               });
//           }
//       };
//   },
// })
