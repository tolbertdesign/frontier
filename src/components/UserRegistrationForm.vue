<template>
  <form method="POST">
    <div>
      <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
        Name
      </label>
      <div class="mt-1 rounded-md shadow-sm">
        <input
          id="name"
          v-model="name"
          type="text"
          required
          autofocus
          class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
        >
      </div>
    </div>

    <div class="mt-6">
      <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
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
      <label for="password" class="block text-sm font-medium leading-5 text-gray-700">
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
      <label for="password-confirm" class="block text-sm font-medium leading-5 text-gray-700">
        Confirm Password
      </label>

      <div class="mt-1 rounded-md shadow-sm">
        <input
          id="password-confirm"
          v-model="passwordConfirmation"
          type="password"
          class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
          required
        >
      </div>
    </div>

    <div class="mt-6">
      <button
        type="submit"
        class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
        @click.prevent="register"
      >
        Register
      </button>
    </div>
  </form>
</template>

<script>
export default {
  name: 'UserRegistrationForm',
  data () {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      error: '',
    }
  },
  methods: {
    register () {
      if (this.password === this.password_confirmation && this.password.length > 0) {
        axios.post('api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
        })
          .then(response => {
            // Initialize CSRF protection for the application
            axios.get('/sanctum/csrf-cookie').then(response => {
              this.$router.go('/dashboard')
            })
          })
          .catch(error => {
            this.error = error
          })
      } else {
        this.password = ''
        this.passwordConfirm = ''
        return alert('Passwords do not match')
      }
    },
  },
}
</script>
