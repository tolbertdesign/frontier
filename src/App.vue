<template>
  <div id="app" class="w-full h-screen transition-all duration-300">
    <Component :is="layout">
      <Transition name="page" mode="out-in">
        <RouterView :key="$route.fullPath" class="page" />
      </Transition>
    </Component>
    <PortalTarget name="modal-outlet" />
    <PortalTarget name="notification-outlet" />
    <PortalTarget name="debug-outlet" />
    <CookieConsent
      message="We use cookies to help make Boosterthon better. By visiting this site, you agree to our cookie policy"
      link-label="Privacy Policy"
      href="/privacy"
    />
  </div>
</template>

<script>
import CookieConsent from 'vue-cookieconsent-component/src/components/CookieConsent.vue'
import User from '../mock_server'
import appConfig from '@/app.config'
const defaultLayout = 'Default'

export default {
  name: 'App',
  components: { CookieConsent },
  data () {
    return {
      width: null,
      height: null,
      showNavigation: false,
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
    console.log(User.first_name)
    console.log('NODE_ENV', process.env.NODE_ENV)
    console.log('BASE_URL', process.env.BASE_URL)
    console.log('VUE_APP_TITLE', process.env.VUE_APP_TITLE)
    console.log('VUE_APP_SERVER_URL', process.env.VUE_APP_SERVER_URL)
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
      { name: 'theme-color', content: appConfig.themes.dark.primary.base },
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

<style lang="scss">
// Import Bulma's core
@import '~bulma/sass/utilities/_all';

// 1. Import the initial variables
@import "~bulma/sass/utilities/initial-variables";

// Import only what you need from Bulma
// @import "~bulma/sass/utilities/_all.sass";
// @import "~bulma/sass/base/_all.sass";
// @import "~bulma/sass/elements/button.sass";
// @import "~bulma/sass/elements/container.sass";
// @import "~bulma/sass/elements/title.sass";
// @import "~bulma/sass/form/_all.sass";
// @import "~bulma/sass/components/navbar.sass";
// @import "~bulma/sass/layout/hero.sass";
// @import "~bulma/sass/layout/section.sass";

// @import "~bulma/sass/layout/hero";
@import "~bulma/sass/layout/footer";
@import "~bulma/sass/layout/section";
@import "~bulma/sass/grid/tiles";
@import "~bulma/sass/elements/box";
// @import "~bulma/sass/elements/other";
@import "~bulma/sass/elements/notification";
@import "~bulma/sass/components/breadcrumb";
@import "~bulma/sass/components/dropdown";
@import "~bulma/sass/components/level";
@import "~bulma/sass/components/media";
@import "~bulma/sass/components/menu";
@import "~bulma/sass/components/navbar";
@import "~bulma/sass/components/tabs";

// @import '../assets/sass/components/collapse';
// @import '../assets/sass/components/datepicker';
// @import '../assets/sass/components/dialog';
// @import '../assets/sass/components/loading';
// @import '../assets/sass/components/message';
// @import '../assets/sass/components/modal';
// @import '../assets/sass/components/notices';
// @import '../assets/sass/components/switch';
// @import '../assets/sass/components/table';

/* @import url('https://rsms.me/inter/inter.css');
html { font-family: 'Inter', sans-serif; }
@supports (font-variation-settings: normal) {
  html { font-family: 'Inter var', sans-serif; }
} */

// * {
//   transition: .2s all;
// }

hr.style-eight {
    overflow: visible; /* For IE */
    padding: 0;
    border: none;
    border-top: medium double #333;
    color: #333;
    text-align: center;
}
hr.style-eight:after {
    content: "OR";
    display: inline-block;
    position: relative;
    top: -0.7em;
    font-size: 1.5em;
    padding: 0 0.25em;
    background: white;
}
.heroicon-outline {
  fill: #626262; }

.heroicon-component-fill {
  fill: white; }

.heroicon-component-accent {
  fill: var(--color-tertiary);
}

.heroicon-shadows {
  fill: #626262;
  opacity: .4;
}
nav a.is-active{
  border-bottom-color: theme('borderColor.gray.500', currentColor);
}

</style>

<style lang="scss">
/* @import url("https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,700,700i"); */
/* @import url("https://blokkfontcom-losgordos.netdna-ssl.com/v2/blokkfont.css"); */
@import "tailwindcss/base";

@font-face {
  font-family: "Blokk";
  font-weight: 400;
  src: url(/font/blokk/BLOKK-Regular.woff) format("woff");
}

@font-face {
  font-family: "Blokk Neue";
  font-weight: 500;
  src: url(/font/blokk/BLOKKNeue-Regular.woff) format("woff");
}

@font-face {
  font-family: "Frankin Gothic";
  font-weight: 400;
  src: url(/font/franklin_gothic/FranklinGothic-Book-webfont.woff) format("woff");
}

@font-face {
  font-family: "Frankin Gothic";
  font-weight: 500;
  src: url(/font/franklin_gothic/FranklinGothic-Med-webfont.woff) format("woff");
}

@font-face {
  font-family: Inter;
  font-weight: 400;
  src: url(/font/inter/Inter-Regular.woff) format("woff");
}

@font-face {
  font-family: Inter;
  font-weight: 500;
  src: url(/font/inter/Inter-Medium.woff) format("woff");
}

/**
 * It's a good idea to use `@apply` or `theme()` to define these styles
 * to avoid introducing new magic values or accidentally deviating
 * from your design system.
 */

/**
 * `theme()` can be a useful alternative to `@apply` when you want to
 * reference a value from your theme configuration for only part of
 * a declaration:
 */

.content-area {
  height: calc(100vh - theme('spacing.12'));
}

.btn-blue {
  background-color: theme('colors.blue.500');
}

h1 {
  @apply text-2xl;
}
h2 {
  @apply text-xl;
}
h3 {
  @apply text-lg;
}
a {
  @apply text-blue-600 underline;
}

@import "tailwindcss/components";

@import "tailwindcss/utilities";

@import "@/assets/css/motion.scss";
@import "@/assets/css/header.scss";
@import "@/assets/css/navbar.scss";
@import "@/assets/css/themes.scss";

html {
  --spacing: 10px;
  --spacing-L: var(--spacing) * 2;
  --spacing-XL: var(--spacing) * 3;
  --importantNumber: 2;
  --H: 100;
  --S: 100%;
  --L: 50%;
}

body {
  color: var(--text);
  background: var(--bg);
  transition: background 500ms ease-in-out, color 1000ms ease-in-out;
}

a { color: currentColor; text-decoration: none; }

.badge {
  @apply inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700;
  &:hover {
    @apply bg-gray-300;
  }
}

.container {
  /* @apply min-h-screen flex justify-center items-center text-center mx-auto; */
  /* background: linear-gradient(270deg, #0E6251, #28B463); */
}

.main-content {
  height: calc(100vh - 80px);
}

.el {
  font-size: calc(3vw + 2px);
  width: calc(100% - 20px);
  height: calc(100vh - 80px);
  padding: calc(1vw + 5px);

  margin: 10px calc(2vw + 5px);
  border-radius: 15px calc(15px / 3) 4px 2px;
  transition: transform calc(1s - 120ms);

  background: hsl(
    calc(var(--H) + 20),
    calc(var(--S) - 10%),
    calc(var(--L) + 30%)
  );

  background: #1e88e5
    linear-gradient(
      to bottom,
      #1e88e5,
      #1e88e5 calc(50% - 10px),
      #3949ab calc(50% + 10px),
      #3949ab
    );

  transform: rotate(calc(1turn + 45deg));
  animation-delay: calc(1s + 15ms);
}

.el {
  /* Number stays 2, but it has a unit now */
  padding: calc(var(--importantNumber) * 1rem);
}

.module {
  padding: calc(var(--spacing) * 2);
}

.module[data-spacing="XL"] {
  padding: calc(var(--spacing-XL));
}

div.div {
  /* Index value comes from the HTML (with a fallback) */
  animation-delay: calc(var(--index, 1) * 0.2s);
}

</style>
