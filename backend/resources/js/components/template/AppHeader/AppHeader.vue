<template>
  <header
    v-scroll="handleScroll"
    class="app-header fixed w-full px-6 shadow text-white bg-blue bg-cover bg-center z-10"
  >
    <div class="container flex items-center justify-between w-full mx-auto max-w-xl">
      <slot />
      <div class="flex">
        <button
          ref="openButton"
          :class="[ !isOpen ? 'visible' : 'invisible' ]"
          type="button"
          class="inline-block text-white focus:outline-none focus:text-white"
          aria-label="Menu"
          @click="toggle"
        >
          <FontAwesomeIcon
            :icon="['far', 'bars']"
            class="fa-2x text-white"
          />
        </button>
      </div>
    </div>
    <div>
      <Transition
        enter-class="opacity-0"
        enter-active-class="ease-out transition-medium"
        enter-to-class="opacity-100"
        leave-class="opacity-100"
        leave-active-class="ease-out transition-medium"
        leave-to-class="opacity-0"
        appear
      >
        <div
          v-show="isOpen"
          class="z-10 fixed pin transition-opacity"
        >
          <div
            class="absolute pin bg-black opacity-50"
            tabindex="-1"
            @click="close"
          />
        </div>
      </Transition>
      <Transition
        enter-class="translate-x-full"
        enter-active-class="ease-out transition-slow"
        enter-to-class="translate-x-0"
        leave-class="translate-x-0"
        leave-active-class="ease-in transition-medium"
        leave-to-class="translate-x-full"
        appear
      >
        <nav
          v-show="isOpen"
          class="ocm z-10 absolute  max-w-xs pin-t pin-r right-0 mr-0 w-full bg-white transition-transform shadow-lg"
        >
          <button
            type="button"
            class="absolute mt-4 -ml-8 inline-block text-white focus:outline-none focus:text-white"
            aria-label="Close"
            @click="close"
          >
            <FontAwesomeIcon
              :icon="['fal', 'times']"
              class="fa-2x text-white"
            />

          </button>
          <div class="max-h-screen overflow-y-auto">
            <!-- Program(s) Section -->
            <div class="relative z-10 bg-white">
              <div
                v-for="(program, index) in activePrograms"
                :key="index"
                :class="program.microsite.microsite_color_theme.theme_name"
              >
                <div class="nav-section themed flex items-baseline justify-between m-0 p-2 px-4 leading-tight text-grey-darker font-bold border-t-8 bg-grey-light">
                  <div
                    :class="['mr-1', {
                      'w-2/3': !getMinIdParticipant(program).participant_info.family_pledging_enabled,
                    }]"
                    class="mr-1"
                  >{{ program.event_name }}</div>
                  <span
                    v-if="!getMinIdParticipant(program).participant_info.family_pledging_enabled"
                    class="w-1/3 ml-1 pr-1 inline-block text-xs text-grey-darker font-medium text-right truncate"
                  >
                    {{ getMinIdParticipant(program).first_name }}
                  </span>
                </div>

                <a
                  v-if="isTeacherDashoardLink(program)"
                  :class="{
                    'is-active': isPageActive(index, 'teacher-dashboard', program.participants[0].id)
                  }"
                  class="m-0 p-4 px-4 font-medium text-blue-dark border-grey-light focus:text-blue-darker hover:text-blue-darker active:text-blue-darker hover:bg-grey-lighter border-b"
                  @click="navigateTo(index, 'teacher-dashboard', program.participants[0].id, program.event_name)"
                >
                  {{ lang.teacher_dashboard }}
                </a>
                <a
                  v-else
                  :class="{
                    'is-active': isPageActive(index, 'parent-dashboard', getMinIdParticipant(program).id)
                  }"
                  class="m-0 p-4 px-4 font-medium text-blue-dark border-grey-light focus:text-blue-darker hover:text-blue-darker active:text-blue-darker hover:bg-grey-lighter border-b"
                  @click="navigateTo(index, 'parent-dashboard', getMinIdParticipant(program).id, program.event_name)"
                >
                  {{ lang.home }}
                </a>

                <a
                  :class="{
                    'is-active': isPageActive(index, 'easy-emailer', getMinIdParticipant(program).id)
                  }"
                  class="m-0 p-4 px-4 font-medium text-blue-dark border-grey-light focus:text-blue-darker hover:text-blue-darker active:text-blue-darker hover:bg-grey-lighter border-b"
                  @click="navigateTo(index, 'easy-emailer', getMinIdParticipant(program).id)"
                >
                  {{ lang.easy_emailer }}
                </a>

                <a
                  v-if="isFinishLineEligible(program)"
                  :class="{
                    'is-active': isPageActive(index, 'finish-line', getMinIdParticipant(program).id)
                  }"
                  class="m-0 p-4 px-4 font-medium text-blue-dark border-grey-light focus:text-blue-darker hover:text-blue-darker active:text-blue-darker hover:bg-grey-lighter border-b"
                  @click="navigateTo(index, 'finish-line', getMinIdParticipant(program).id)"
                >
                  {{ lang.finish_line }}
                </a>
              </div>
            </div>

            <!-- Registration Section -->
            <div class="relative z-10 bg-white">
              <AppHeaderNavSection>
                {{ lang.registration }}
              </AppHeaderNavSection>
              <AppHeaderNavLink href="/v3/register/participant">
                {{ lang.register_student }}
              </AppHeaderNavLink>
              <AppHeaderNavLink
                href="#"
                @click="goToTeacherRegistration"
              >
                {{ lang.register_teacher }}
              </AppHeaderNavLink>
            </div>

            <!-- My Settings Section -->
            <div class="relative z-10 bg-white pb-32 lg:pb-0">
              <AppHeaderNavSection>
                {{ lang.my_settings }}
              </AppHeaderNavSection>
              <AppHeaderNavLink
                v-if="isOrgAdmin"
                :href="`/v3/tkdashboard/?redirect=/admin`"
                class="org-admin-link"
              >
                {{ lang.admin_dashboard }}
              </AppHeaderNavLink>
              <RouterLink
                :to="{ name: 'edit-profile' }"
                class="m-0 p-4 px-4 font-medium text-blue-dark border-grey-light focus:text-blue-darker hover:text-blue-darker active:text-blue-darker hover:bg-grey-lighter border-b"
              >
                {{ lang.my_profile }}
              </RouterLink>
              <AppHeaderNavLink :href="`/v3/tkdashboard/?redirect=home/help`">
                {{ lang.help_center }}
              </AppHeaderNavLink>
              <AppHeaderNavLink href="/v3/logout">
                {{ lang.logout }}
              </AppHeaderNavLink>
            </div>
          </div>
        </nav>
      </Transition>
    </div>
  </header>
</template>

<script>
import Scroll from '@/directives/scroll'
import PageHeader from '@/components/pattern/PageHeader'
import ProgramHeader from '@/components/pattern/ProgramHeader'
import NotificationsSidebarToggle from '@/components/pattern/NotificationsSidebarToggle'
import AppHeaderNavLink from '@/components/template/AppHeaderNavLink'
import AppHeaderNavSection from '@/components/template/AppHeaderNavSection'
import { mapGetters, mapState } from 'vuex'

export default {
  name: 'AppHeader',
  status: 'prototype',
  release: '1.0.0',
  components: {
    PageHeader,
    ProgramHeader,
    NotificationsSidebarToggle,
    AppHeaderNavLink,
    AppHeaderNavSection,
  },
  directives: {
    Scroll,
  },
  props: {
    program: {
      type: Object,
      default: null,
    },
    index: {
      type: Number,
      default: 0,
    },
  },
  data () {
    return {
      isOpen: false,
      orgAdmin: 50,
    }
  },
  computed: {
    ...mapGetters(['activePrograms']),
    ...mapState(['lang']),
    isOrgAdmin () {
      return this.$store.state.User.group_membership.includes(this.orgAdmin)
    },
    teacherParticipantId () {
      return this.$store.state.User.teacher_participant_id
    },
  },
  watch: {
    isOpen: {
      immediate: true,
      handler (isOpen) {
        if (isOpen) {
          // Disable scrolling.
          document.body.style.setProperty('overflow', 'hidden')
          document.documentElement.style.setProperty('overflow', 'hidden')
        } else {
          // Enable scrolling.
          document.body.style.removeProperty('overflow')
          document.documentElement.style.removeProperty('overflow', 'hidden')
        }
      },
    },
  },
  methods: {
    getMinIdParticipant (program) {
      return program.participants.reduce((min, current) => min.id < current.id ? min : current)
    },
    open () {
      this.isOpen = true
    },
    close () {
      this.isOpen = false
    },
    toggle () {
      this.isOpen = !this.isOpen
    },
    navigateTo (index, routeName, id, eventName) {
      this.$router.push({
        name: routeName,
        query: {
          p: index,
        },
        params: {
          participantUserId: id,
        },
      })
      this.close()
      this.$store.dispatch('setActiveTab', index)
      this.$store.state.activeEventName = eventName
    },
    isPageActive (index, routeName, id) {
      return this.$route.name === routeName && (this.$route.params.participantUserId === id || this.$store.state.activeTab === index)
    },
    isTeacherDashoardLink (program) {
      const teacherParticipant = program.participants.find(participant => {
        return participant.id === this.$store.state.User.teacher_participant_id
      })

      if (teacherParticipant) {
        return true
      }
      return false
    },
    isFinishLineEligible (program) {
      let isEligible = false
      const today = new Date()
      const tomorrow = new Date(today)
      tomorrow.setDate(tomorrow.getDate() + 1)

      program.participants.forEach(participant => {
        if (new Date(program.fun_run) < tomorrow && participant.laps !== null) {
          isEligible = true
        }
      })

      return isEligible
    },
    handleScroll (evt, el) {
      if (window.scrollY > 50) {
        el.classList.add('shrink')
      } else {
        el.classList.remove('shrink')
      }
    },
    goToTeacherRegistration () {
      this.gaEvent('Parent Dashboard', 'Register Teacher', 'View')
      window.location.href = '/v3/register/teacher'
    },
  },
}
</script>
