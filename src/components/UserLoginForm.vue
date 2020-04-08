<template>
  <div id="user-login">
    <header class="mb-6">
      <h1 class="text-2xl text-white text-center">
        {{ msg }}
      </h1>
    </header>

    <form method="POST" action="/login">
      <div>
        <label for="email" class="block text-sm font-medium leading-5 text-white">
          Email address
        </label>
        <div class="mt-1 rounded-md shadow-sm">
          <input
            id="email"
            v-model="email"
            type="email"
            required
            autofocus
            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
          >
        </div>
      </div>

      <div class="mt-6">
        <label for="password" class="block text-sm font-medium leading-5 text-white">
          Password
        </label>
        <div class="mt-1 rounded-md shadow-sm">
          <input
            id="password"
            v-model="password"
            type="password"
            required
            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
          >
        </div>
      </div>

      <div class="mt-6">
        <button
          type="submit"
          class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
          @click.prevent="login"
        >
          Sign in
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'UserLoginForm',
  props: {
    msg: {
      type: String,
      default: '👋 Welcome to Frontier, a themeable design system',
    },
  },
  data () {
    return {
      email: 'victor.tolbert@outlook.com',
      password: 'password',
      error: '',
    }
  },
  computed: {
    ...mapGetters({
      loggedIn: 'auth/loggedIn',
    }),
  },
  methods: {
    login () {
      if (this.password.length > 0) {
        axios.get('/sanctum/csrf-cookie').then(() => {
          axios.post('api/login', {
            email: this.email,
            password: this.password,
          }).then(({ data }) => {
            // console.log(data)
            this.$store.commit('auth/SET_USER_DATA', data)

            this.$router.push({ name: 'dashboard' })
          }).catch((error) => {
            this.error = error
          })
        })
        // this.$store.dispatch('login', {
        //   email: this.email,
        //   password: this.password,
        // }).then(() => {
        //   this.$router.push('/')
        // })
      }
    },
  },
}
</script>
