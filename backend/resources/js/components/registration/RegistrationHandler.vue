<template>
  <div>
    <progress-bar :width="pg_width" />
    <back
      v-if="showBackButton"
      @back-button="_back"
    />
    <div class="registration">
      <welcome
        v-if="position=='welcome'"
        :login_url="login_url"
        class="animated fadeIn animated-slow"
        @sign-up="_setPosition()"
      />
      <sign-up
        v-if="position=='sign-up'"
        :login_url="login_url"
        class="animated fadeIn animated-slow"
        @register="_setPosition()"
      />
      <registration-type
        v-if="position == 'registration-type'"
        :login_url="login_url"
        class="animated fadeIn animated-slow"
        @email-registration="_setPosition()"
      />
      <registration-form
        v-if="position == 'registration'"
        :old="old"
        :csrf="csrf"
        :errors="errors"
        :login_url="login_url"
        :register_url="register_url"
        :social_register_url="social_register_url"
        class="animated fadeIn animated-slow"
        @registration-successful="_setPosition()"
        @registration-error="_error()"
      />
      <welcome-back
        v-if="position == 'welcome-back'"
        :is-beta-user="isBetaUser"
        :is-org-admin="isOrgAdmin"
        @selection-made="_setPosition()"
        @incomplete-registration="position=&quot;registration&quot;"
      />
      <welcome-teachers
        v-if="position == 'welcome-teacher'"
        :login_url="login_url"
        :cancel_link="welcomeTeachersCancelLink"
        class="animated fadeIn animated-slow"
        @teacher_registered="_setPosition()"
      />
      <school-search
        v-if="position == 'school-search'"
        :old="old"
        :csrf="csrf"
        :errors="errors"
        :login_url="login_url"
        :register_url="register_url"
        :cancel_link="schoolSearchCancelLink"
        class="animated fadeIn animated-slow auth-pane"
        @participant-registration="_setPosition"
        @registration-error="_error()"
      />
      <participant-form
        v-if="position == 'participant-registration'"
        class="animated fadeIn animated-slow auth-pane"
        @participant-registered="_setPosition()"
      />
      <participant-register-success
        v-if="position == 'participant-register-success'"
        class="animated fadeIn animated-slow"
        @school-search="_setPosition()"
      />
      <div
        v-if="position === 'error'"
        class="animated fadeIn animated-slow"
      >
        <h4 class="mt-12">
          {{ lang.register_error }}
        </h4>
        <p class="mt-8">
          {{ lang.redirect_message }}
        </p>
      </div>
      <Snowf
        v-if="show_snow"
        :amount="150"
        :size="5"
        :speed="1.7"
        :wind="0"
        :opacity="0.8"
        :swing="1"
        :image="null"
        :z-index="-1"
        :resize="true"
        color="#fff"
      />
    </div>
  </div>
</template>

<script>

export default {
  props: {
    lang: {
      type: Object,
      default: null,
    },
    login_url: {
      type: String,
      default: '',
    },
    csrf: {
      type: String,
      default: '',
    },
    errors: {
      type: Array,
      default: null,
    },
    welcome_page: {
      type: String,
      default: '',
    },
    old: {
      type: Array,
      default: null,
    },
    register_url: {
      type: String,
      default: '',
    },
    social_register_url: {
      type: String,
      default: '',
    },
    home_url: {
      type: String,
      default: '',
    },
    user: {
      type: Object,
      default: undefined,
    },
    default_image_url: {
      type: String,
      default: null,
    },
    user_type: {
      type: String,
      default: '',
    },
    show_snow: {
      type: Boolean,
      default: false,
    },
    isBetaUser: {
      type: Boolean,
      default: false,
    },
    isOrgAdmin: {
      type: Boolean,
      default: false,
    },
    logged_in_back_action: {
      type: String,
      default: 'welcome-back',
    },
    starting_position: {
      type: String,
      default: null,
    },
  },
  data: function () {
    return {
      position: 'welcome',
      pg_width: 'd-none',
      agrees_terms: false,
      teacher_registration_code: null,
      parent: false,
      positions: {
        welcome: {
          width: 'd-none',
          back: false,
          step: 1,
          teacher: true,
          parent: true,
        },
        'sign-up': {
          width: 'w-20pct',
          back: true,
          step: 2,
          teacher: true,
          parent: true,
        },
        'registration-type': {
          width: 'w-20pct',
          back: true,
          step: 3,
          teacher: true,
          parent: true,
        },
        registration: {
          width: 'w-40pct',
          back: true,
          step: 4,
          teacher: true,
          parent: true,
        },
        'welcome-teacher': {
          width: 'w-100pct',
          back: true,
          step: 5,
          teacher: true,
          parent: false,
        },
        'school-search': {
          width: 'w-60pct',
          back: true,
          step: 5,
          teacher: false,
          parent: true,
        },
        'participant-registration': {
          width: 'w-80pct',
          back: true,
          step: 6,
          teacher: false,
          parent: true,
        },
        'participant-register-success': {
          width: 'hide',
          back: false,
          step: 7,
          teacher: false,
          parent: true,
        },
        error: {
          width: 'd-none',
          back: false,
          step: -1,
          teacher: true,
          parent: true,
        },
        'welcome-back': {
          width: 'w-20pct',
          back: true,
          step: 4,
          teacher: false,
          parent: false,
        },
      },
    }
  },
  computed: {
    showBackButton () {
      return this.positions[this.position].back
    },
    schoolSearchCancelLink () {
      if (this.logged_in_back_action === 'welcome-back') {
        return '/v3/tkdashboard'
      } else {
        return this.logged_in_back_action
      }
    },
    welcomeTeachersCancelLink () {
      if (this.logged_in_back_action === 'welcome-back') {
        return '/v3/tkdashboard'
      } else {
        return this.logged_in_back_action
      }
    },
  },
  watch: {
    position: function (val) {
      this.pg_width = this.positions[val].width
      document.body.scrollTop = 0
      document.documentElement.scrollTop = 0
    },
  },
  created () {
    // Load the lang into the store
    this.$store.commit('SET_LANG', this.lang)
    this.$store.commit('SET_USER_TYPE', this.user_type)

    // If there is old data lets load directly to the registration page that failed.
    if (this.errors.length !== 0) {
      this.position = 'registration'
      this.teacher_registration_code = this.old.teacher_registration_code
    }
    if (this.user !== null) {
      this.$store.commit('SET_USER', this.user)
      switch (this.$store.getters.getUserType.toLowerCase()) {
      case 'incompleteprofile':
        this.position = 'registration'
        break
      default:
        this.position = 'welcome-back'
        break
      }
    }

    if (this.starting_position) {
      this.position = this.starting_position
    }

    this.$store.commit('SET_DEFAULT_USER_IMAGE', this.default_image_url)
  },
  methods: {
    _back: function () {
      if (this.positions[this.position].step === 2) {
        this.position = 'welcome'
        return
      }
      if (this.position === 'registration' || this.position === 'welcome-back') {
        axios.get('/v3/logout')
        this.$store.commit('RESET_USER')
        this.position = 'welcome'
        return
      }

      if (this.position === 'school-search' || this.position === 'welcome-teacher') {
        this.performLoggedInBackAction()
        return
      }
      const newPosition = _.findIndex(
        _.toArray(this.positions),
        { step: this.positions[this.position].step, [this.$store.state.user_type.toLowerCase()]: true },
      )

      this.position = Object.keys(this.positions)[newPosition - 1]
    },
    _error: function () {
      this.position = 'error'
      setTimeout(() => {
        window.location.href = '/'
      }, 60000)
    },
    _setPosition: function () {
      if (this.positions[this.position].step === 7) {
        this.position = 'school-search'
        return
      } else if (this.positions[this.position].step === 1) {
        this.position = 'sign-up'
        return
      }

      if (this.position === 'welcome-teacher') {
        window.location.href = '/v3/home/teacher-dashboard'
        return
      }

      const nextStep = _.findIndex(_.toArray(this.positions), {
        step: this.positions[this.position].step + 1,
        [this.$store.state.user_type.toLowerCase()]: true,
      })

      // Flip back to dashboard if there isn't another step to take.
      if (nextStep === -1) { window.location.href = '/v3/tkdashboard' }

      this.position = Object.keys(this.positions)[nextStep]
    },
    performLoggedInBackAction: function () {
      if (this.logged_in_back_action === 'welcome-back') {
        this.position = 'welcome-back'
      } else {
        window.location.href = this.logged_in_back_action
      }
    },
  },
}
</script>
