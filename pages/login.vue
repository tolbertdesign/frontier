<template>
  <div
    class="flex items-center justify-center h-screen bg-center bg-cover"
    style="
      background-image: url('/img/school_empty_hallway_shutterstock_472440757.jpg');
    "
  >
    <form ref="loginform" class="w-1/4 p-4 mx-auto" @submit.prevent="login">
      <h1 class="mb-2 text-xl font-semibold">
        Login
      </h1>
      <div class="mb-4">
        <label for="email" class="block mb-1 text-sm">Email</label>
        <input
          type="email"
          name="email"
          class="w-full px-3 py-2 border rounded"
          required
        />
      </div>
      <div class="mb-4">
        <label for="password" class="block mb-1 text-sm">Password</label>
        <input
          type="password"
          name="password"
          class="w-full px-3 py-2 border rounded"
          required
        />
      </div>
      <button
        type="submit"
        class="w-full px-10 py-2 font-semibold text-white bg-blue-500 rounded"
      >
        Login
      </button>
    </form>
  </div>
</template>

<script>
export default {
  layout: 'fullscreen',
  data() {
    return {
      error: {},
    }
  },
  mounted() {
    // Before loading login page, obtain csrf cookie from the server.
    this.$axios.$get('/sanctum/csrf-cookie')
  },
  methods: {
    async login() {
      this.error = {}
      try {
        // Prepare form data
        const formData = new FormData(this.$refs.loginform)

        // Pass form data to `loginWith` function
        await this.$auth.loginWith('local', {data: formData})

        // Redirect user after login
        this.$router.push({
          path: '/',
        })
      } catch (err) {
        this.error = err
        // do something with error
      }
    },
  },
}
</script>
