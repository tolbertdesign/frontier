`<template>
  <nav id="app-nav" class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
      <div class="relative flex items-center justify-between h-16">
        <!-- Left side -->
        <div class="flex items-center px-2 lg:px-0">
          <!-- Branding -->
          <div class="flex items-center flex-shrink-0 text-white">
            <img
              class="block h-8 w-auto mr-2"
              src="http://cominex.net/assets/img/logos/titan-mark.svg"
              alt=""
            >
            <!-- <img class="hidden lg:block h-8 w-auto" src="http://cominex.net/assets/img/logos/frontier.svg" alt=""> -->
            <router-link :to="{ name: 'dashboard' }">
              <AppLogo />
            </router-link>
          </div>
          <!-- Desktop: Router Links -->
          <div class="hidden lg:block lg:ml-6">
            <div class="flex">
              <router-link
                v-if="loggedIn"
                :to="{ name: 'dashboard' }"
                class="px-3 py-2 rounded-md text-sm leading-5 font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out"
              >{{ $t('dashboard') }}</router-link>
              <router-link
                v-if="loggedIn"
                :to="{ name: 'templates' }"
                class="ml-4 px-3 py-2 rounded-md text-sm leading-5 font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out"
              >{{ $t('templates') }}</router-link>
            </div>
          </div>
        </div>
        <!-- Search -->
        <div v-if="loggedIn" class="flex-1 flex justify-center px-2 lg:ml-6 lg:justify-end">
          <!-- Search Input -->
          <div class="max-w-lg w-full lg:max-w-xs">
            <label
              for="search"
              class="sr-only"
            >Search</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg
                  class="h-5 w-5 text-gray-400"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"
                  />
                </svg>
              </div>
              <input
                id="search"
                class="block w-full pl-10 pr-3 py-2 border border-transparent rounded-md leading-5 bg-gray-700 placeholder-gray-400 focus:outline-none focus:bg-white sm:text-sm transition duration-150 ease-in-out"
                placeholder="Search"
              >
            </div>
          </div>
        </div>
        <!-- Mobile: Menu Toggle -->
        <div v-if="loggedIn" class="flex lg:hidden">
          <button
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out"
            @click.prevent="toggle"
          >
            <svg
              class="h-6 w-6"
              stroke="currentColor"
              fill="none"
              viewBox="0 0 24 24"
            >
              <!-- Bars path -->
              <path
                ref="bars"
                :class="{ 'hidden': open, 'inline-flex': !open }"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
              <!-- Times path -->
              <path
                ref="times"
                :class="{ 'hidden': !open, 'inline-flex': open }"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
        <!-- Desktop: Alerts and UserAvatar Icon Buttons -->
        <div v-if="loggedIn" class="hidden lg:block lg:ml-4">
          <div class="flex items-center">
            <!-- AlertsIconButton -->
            <button
              class="flex-shrink-0 p-1 border-2 border-transparent text-gray-400 rounded-full hover:text-white focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out"
            >
              <svg
                class="h-6 w-6"
                stroke="currentColor"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                />
              </svg>
            </button>
            <!-- UserAvatarIconButton -->
            <!-- v-click-outside="() => {open = false }" -->
            <div class="ml-4 relative flex-shrink-0">
              <div>
                <button
                  class="flex text-sm rounded-full text-white focus:outline-none focus:shadow-solid transition duration-150 ease-in-out"
                  @click="open = !open"
                >
                  <v-gravatar
                    class="h-8 w-8 rounded-full"
                    :email="user.email"
                  />
                </button>
              </div>
              <Transition
                enter-active-class="transition ease-out duration-100"
                enter-class="transform opacity-0 scale-95"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-75"
                leave-class="transform opacity-100 scale-100"
                leave-to-class="transform opacity-0 scale-95"
              >
                <div
                  v-show="open"
                  class="transform origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg"
                >
                  <div class="py-1 rounded-md bg-white shadow-xs">
                    <router-link
                      v-if="loggedIn"
                      class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                      :to="{ name: 'profile' }"
                    >{{ $t('edit_profile.nav_link_text') }}</router-link>
                    <router-link
                      :to="{ name: 'settings' }"
                      class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                    >{{ $t('settings') }}</router-link>
                    <button
                      class="block w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out cursor-pointer"
                      type="button"
                      @click="logout"
                    >{{ $t('logout') }}</button>
                  </div>
                </div>
              </Transition>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--  -->
    <div id="here" :class="{ 'block': open, 'hidden': !open }" class="lg:hidden">
      <div class="px-2 pt-2 pb-3">
        <router-link
          :to="{ name: 'dashboard' }"
          class="block px-3 py-2 rounded-md text-base font-medium text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out"
        >{{ $t('dashboard') }}</router-link>
        <router-link
          :to="{ name: 'templates' }"
          class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out"
        >{{ $t('templates') }}</router-link>
      </div>
      <div class="pt-4 pb-3 border-t border-gray-700">
        <div v-if="loggedIn" class="flex items-center px-5">
          <div class="flex-shrink-0">

            <v-gravatar
              class="h-10 w-10 rounded-full"
              :email="user.email"
            />

          </div>
          <div class="ml-3">
            <div class="text-base font-medium leading-6 text-white">
              {{ user.name }}
            </div>
            <div class="text-sm font-medium leading-5 text-gray-400">
              {{ user.email }}
            </div>
          </div>
        </div>
        <div class="mt-3 px-2">
          <router-link
            :to="{ name: 'profile' }"
            class="block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out"
          >{{ $t('edit_profile.nav_link_text') }}</router-link>
          <router-link
            :to="{ name: 'settings' }"
            class="mt-1 block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out"
          >{{ $t('settings') }}</router-link>
          <button
            class="mt-1 border border-red-600 w-full text-left block px-3 py-2 rounded-md text-base font-medium text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out"
            @click="logout"
          >{{ $t('logout') }}</button>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import vClickOutside from 'v-click-outside'

export default {
  name: 'AppNav',
  directives: {
    clickOutside: vClickOutside.directive,
  },
  data () {
    return {
      open: false,
    }
  },
  computed: {
    ...mapGetters({
      user: 'auth/user',
      loggedIn: 'auth/loggedIn',
    }),
  },
  // watch: {
  //   '$route' (to, from) {
  //     console.log('to: ', to)
  //     console.log('from: ', from)
  //     // const id = to.params.id
  //     // this.AJAXRequest(id)
  //   },
  // },
  methods: {
    logout () {
      this.$store.dispatch('auth/logout')
      this.$router.push({ name: 'welcome' })
      // this.$router.go('/')
    },
    toggle () {
      this.open = !this.open
    },
  },
}
</script>
