<template>
  <div id="app" class="w-full h-screen transition-all duration-300">
    <StoreLoader
      :user="currentUser"
      :s3_bucket="awsBucket"
      :beta_banner_kill_switch="betaBannerKillSwith"
      :min_password_length="minPassordLength"
      :avatar_path="avatarPath"
      :pledge_types="pledgeTypes"
      :sponsor_types="sponsorTypes"
      :countries="countries"
      :states="states"
      :lang="lang"
    />
    <Component :is="layout">
      <Transition name="page" mode="out-in">
        <RouterView :key="$route.fullPath" class="page" />
      </Transition>
    </Component>
    <PortalTarget name="modal-outlet" />
    <PortalTarget name="notification-outlet" />
    <PortalTarget name="debug-outlet" />
    <!-- <Consent
      message="I use Cookies for user analysis and on-page improvements!"
      link-label="Privacy Policy"
      href="https://lichter.io/privacy/"
    /> -->
  </div>
</template>

<script>
import Consent from 'vue-cookieconsent-component/src/components/CookieConsent.vue'
import appConfig from '@/app.config'
const defaultLayout = 'Default'

export default {
  name: 'DashboardApp',
  components: { Consent },
  data () {
    return {
      width: null,
      height: null,
      showNavigation: false,
      avatarPath: null,
      awsBucket: null,
      betaBannerKillSwith: null,
      countries: null,
      currentUser: null,
      lang: null,
      minPassordLength: 7,
      pledgeTypes: null,
      sponsorTypes: null,
      states: null,
    }
  },
  computed: {
    layout () {
      return (this.$route.meta.layout || defaultLayout) + 'Layout'
    },
  },
  mounted () {
    this.width = this.$el.getBoundingClientRect().width + 'px'
    this.height = this.$el.getBoundingClientRect().height + 'px'
  },
  page: {
    title: appConfig.title,
    titleTemplate (title) {
      title = typeof title === 'function' ? title(this.$store) : title
      return title ? `${title} | ${appConfig.title}` : appConfig.title
    },
    htmlAttrs: {
      lang: 'en',
    },
    base: { target: '_blank', href: '/' },
    meta: [
      { hid: 'author', name: 'author', content: appConfig.url },
      { name: 'publisher', content: appConfig.url },
      { name: 'apple-mobile-web-app-title', content: appConfig.title },
      { name: 'theme-color', content: appConfig.themeColor },
      // Facebook
      { name: 'og:title', content: appConfig.title },
      { name: 'og:description', content: appConfig.description },
      { name: 'og:type', content: 'website' },
      { name: 'og:url', content: appConfig.url },
      { name: 'og:image', content: appConfig.img },
      { name: 'og:locale', content: appConfig.locale },
      // Twitter
      { name: 'twitter:card', content: 'summary_large_image' },
      { name: 'twitter:site', content: appConfig.twitter },
      { name: 'twitter:creator', content: appConfig.twitter },
      { name: 'twitter:title', content: appConfig.title },
      { name: 'twitter:description', content: appConfig.description },
      { name: 'twitter:image', content: appConfig.img },
    ],
  },
}
</script>
