<template>
  <nav class="bg-gray-900">
    <div class="px-4 mx-auto sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <NuxtLink
              to="/"
              class="flex items-center text-gray-200 hover:text-white"
            >
              <TheLogo class="w-8 h-8" />

              <h1 class="ml-2 text-2xl font-bold">
                <slot>Frontier</slot>
              </h1>
            </NuxtLink>
          </div>

          <div class="hidden md:block">
            <div class="flex items-baseline ml-10">
              <NuxtLink
                v-for="(link, i) in links"
                :key="i"
                v-slot="{navigate, href, isExactActive}"
                :to="link.to"
              >
                <a
                  :href="href"
                  class="px-3 py-2 text-sm font-medium rounded-md"
                  :class="[
                    isExactActive
                      ? 'text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700'
                      : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700',
                    i > 0 && 'ml-4',
                  ]"
                  @click="navigate"
                  >{{ link.text }}</a
                >
              </NuxtLink>
            </div>
          </div>
        </div>

        <div class="hidden md:block">
          <div class="flex items-center ml-4 md:ml-6">
            <a
              href="https://github.com/tolbertdesign/frontier"
              target="_blank"
              class="text-gray-400 border-2 border-transparent rounded-full hover:text-white focus:outline-none focus:text-white focus:bg-gray-700"
            >
              <!-- <GithubIcon /> -->

              <IconGithub class="w-8 h-8" />
            </a>

            <!-- <button
              class="p-1 text-gray-400 border-2 border-transparent rounded-full hover:text-white focus:outline-none focus:text-white focus:bg-gray-700"
              aria-label="Notifications"
            >
              <BellIcon />
            </button> -->

            <!-- Profile dropdown -->
            <div class="relative ml-3">
              <div>
                <button
                  id="user-menu"
                  class="flex items-center max-w-xs text-sm text-white rounded-full focus:outline-none focus:shadow-solid"
                  aria-label="User menu"
                  aria-haspopup="true"
                  @click="showProfileMenu = !showProfileMenu"
                >
                  <img
                    class="w-8 h-8 rounded-full"
                    src="/img/minion.png"
                    alt=""
                  />
                </button>
              </div>

              <transition
                enter-active-class="transition duration-100 ease-out"
                enter-from-class="transform scale-95 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-75 ease-in"
                leave-from-class="transform scale-100 opacity-100"
                leave-to-class="transform scale-95 opacity-0"
              >
                <div
                  v-if="showProfileMenu"
                  class="absolute right-0 w-48 mt-2 origin-top-right rounded-md shadow-lg"
                >
                  <div
                    class="py-1 bg-white rounded-md shadow-xs"
                    role="menu"
                    aria-orientation="vertical"
                    aria-labelledby="user-menu"
                  >
                    <NuxtLink
                      to="/profile"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      role="menuitem"
                      >Your Profile
                    </NuxtLink>

                    <NuxtLink
                      to="/settings"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      role="menuitem"
                    >
                      Settings
                    </NuxtLink>

                    <a
                      href="#"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                      role="menuitem"
                      >Sign out</a
                    >
                  </div>
                </div>
              </transition>
            </div>
          </div>
        </div>

        <div class="flex -mr-2 md:hidden">
          <!-- Mobile menu button -->
          <button
            class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white"
            @click="showMenu = !showMenu"
          >
            <!-- Menu open: "hidden", Menu closed: "block" -->
            <svg
              class="block w-6 h-6"
              stroke="currentColor"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>

            <!-- Menu open: "block", Menu closed: "hidden" -->
            <svg
              class="hidden w-6 h-6"
              stroke="currentColor"
              fill="none"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div class="md:hidden" :class="showMenu ? 'block' : 'hidden'">
      <div class="px-2 pt-2 pb-3 sm:px-3">
        <NuxtLink
          v-for="(link, i) in links"
          :key="i"
          v-slot="{navigate, href, isExactActive}"
          :to="link.to"
        >
          <a
            :href="href"
            class="block px-3 py-2 text-base font-medium rounded-md"
            :class="[
              isExactActive
                ? 'text-white bg-gray-900 focus:outline-none focus:text-white focus:bg-gray-700'
                : 'text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700',
              i > 0 && 'mt-1',
            ]"
            @click="navigate().then(() => (showMenu = false))"
            >{{ link.text }}</a
          >
        </NuxtLink>
      </div>

      <div class="pt-4 pb-3 border-t border-gray-700">
        <div class="flex items-center px-5">
          <div class="flex-shrink-0">
            <img class="w-10 h-10 rounded-full" src="/img/minion.png" alt="" />
          </div>

          <div class="ml-3">
            <div class="text-base font-medium leading-none text-white">
              Demo User
            </div>

            <div class="mt-1 text-sm font-medium leading-none text-gray-400">
              demo.user@example.com
            </div>
          </div>
        </div>

        <div class="px-2 mt-3">
          <NuxtLink
            to="/profile"
            class="block px-3 py-2 text-base font-medium text-gray-400 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700"
          >
            Your Profile
          </NuxtLink>

          <NuxtLink
            to="/settings"
            class="block px-3 py-2 mt-1 text-base font-medium text-gray-400 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700"
          >
            Settings
          </NuxtLink>

          <a
            href="#"
            class="block px-3 py-2 mt-1 text-base font-medium text-gray-400 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700"
            >Sign out</a
          >
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import {BellIcon, MenuIcon, GithubIcon} from 'vue-feather-icons'
// import {BellIcon, MenuIcon} from '@vue-hero-icons/solid'

export default {
  name: 'TheNavbar',
  components: {BellIcon, MenuIcon, GithubIcon},
  data: () => ({
    showMenu: false,
    showProfileMenu: false,
    links: [
      // {text: 'Home', to: '/'},
      // {text: 'Corporate Match', to: '/corporate-match'},
      // {text: 'Examples', to: '/examples/1'},
      {text: 'Schools', to: '/schools'},
      {text: 'Programs', to: '/programs'},
      {text: 'Users', to: '/users'},
    ],
  }),
}
</script>
