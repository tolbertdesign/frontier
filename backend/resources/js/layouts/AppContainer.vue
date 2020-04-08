<template>
  <div class="app-container">
    <main class="page-content bg-white">
      <RouterView />
      <AppFooter />
    </main>

    <div
      id="default-loading"
      class="z-10 fixed pin transition-opacity hidden"
    >
      <div
        class="absolute pin bg-black opacity-50"
        tabindex="-1"
      />
      <div class="flex items-center justify-center h-screen">
        <FontAwesomeIcon
          class="text-white"
          icon="cog"
          size="3x"
          spin
        />
      </div>
    </div>
  </div>
</template>

<script>
import AppFooter from './AppFooter'

export default {
  name: 'AppContainer',
  components: {
    AppFooter,
  },
  computed: {
    programs () {
      return this.$store.state.User.programs
    },
  },
}
</script>
<style>
:root {
  --color-primary: #2db564;
  --color-secondary: #2e86de;
  --color-tertiary: #ed8936;
  --color-danger: #d32f2f;
  --color-modal-button: #d0021b;
  --color-facebook: #3b5998;
  --color-emailer: #00a6d9;
  --color-sms: #57af7b;
  --color-copy: #00999e;
  --color-secondary-stroke: #7f8fa4;
  --color-text: #4a4a4a;
  --color-disable-gray: #efefef;
  --color-bg-tooltip: #eef2f7;
  --color-white: #f9fafc;
  --color-bg-white: #f9f9f9;
  --color-header-light: #027ed7;
  --color-header-dark: #02098a;

  /* Examples  */
  --color-bg-primary: #0252cc;
  --color-bg-secondary: #ffc402;
  --color-bg-default: #fff;
  --color-bg-inverse: #fff;
  --color-text-primary: #fff;
  --color-text-secondary: #755f17;
  --color-text-default: #444;
  --color-text-default-soft: #999;
  --color-text-inverse: #444;
  --color-text-inverse-soft: #999;
  --font-display: "Helvetica Neue", Helvetica, Arial, sans-serif;
  --font-body: "Helvetica Neue", Helvetica, Arial, sans-serif;
  --font-weight-normal: 400;
  --font-weight-display: 400;
  --font-weight-btn: 600;
  --rounded-btn: .25rem;
}
</style>

<style lang="scss">

// Import Bulma's core
@import '~bulma/sass/utilities/_all';

// 1. Import the initial variables
@import "~bulma/sass/utilities/initial-variables";

// 2. Set your own initial variables

// Named Brand Colors
$solitude                   : #f8fcff;
$congress-blue              : #02518a;
$mariner                    : #2e86de;
$shakespeare                : #57b6d3;
$bondi-blue                 : #02b6bc;
$aqua-forest                : #57af7b;
$sea-green                  : #2db564;
$coral                      : #faa638;
$monza                      : #d0021b;
$facebook-blue              : #3B5998;
$email-blue                 : #00A6D9;
$text-message-green         : #57AF7B;
$copy-link-green            : #00999E;

$red                        : $monza;
$blue                       : $mariner;
$green                      : $sea-green;
$orange                     : $coral;

// Primary Colors
$primary                    : $green;
$primary-invert             : findColorInvert($primary);
$secondary                  : $blue;
$secondary-invert           : findColorInvert($secondary);
$tertiary                   : $orange;
$tertiary-invert            : findColorInvert($tertiary);

// Alerts and messages
$danger                     : $red;
$danger-invert              : findColorInvert($danger);
$warning                    : $orange;
$warning-invert             : findColorInvert($warning);
$success                    : $green;
$success-invert             : findColorInvert($success);
$info                       : $blue;
$info-invert                : findColorInvert($info);

$facebook                   : $facebook-blue;
$facebook-invert            : findColorInvert($facebook);
$email                      : $email-blue;
$email-invert               : findColorInvert($email);
$text-message               : $text-message-green;
$text-message-invert        : findColorInvert($text-message);
$copy-link                  : $copy-link-green;
$copy-link-invert           : findColorInvert($copy-link);

// Setup $colors to use as bulma classes (e.g. 'is-twitter')
$colors: (
    'white'                 : ($white, $black),
    'black'                 : ($black, $white),
    'light'                 : ($light, $light-invert),
    'dark'                  : ($dark, $dark-invert),
    'primary'               : ($primary, $primary-invert),
    'secondary'             : ($secondary, $secondary-invert),
    'tertiary'              : ($tertiary, $tertiary-invert),
    'info'                  : ($info, $info-invert),
    'success'               : ($success, $success-invert),
    'warning'               : ($warning, $warning-invert),
    'danger'                : ($danger, $danger-invert),
    'facebook'              : ($facebook, $facebook-invert),
    'email'                 : ($email, $email-invert),
    'text-message'          : ($text-message, $text-message-invert),
    'copy-link'             : ($copy-link, $copy-link-invert),
);

// Typography
$font-path                  : "/v3-assets/dashboard/fonts";
$family-serif               : "Merriweather", "Georgia", serif;
$family-sans-serif          : 'Source Sans Pro', 'Roboto', sans-serif;
$family-monospace           : "Operator Mono", "Roboto Mono", "Consolas", monospace;
$family-primary             : $family-sans-serif;

// Font Weight
$weight-light               : 300;
$weight-normal              : 400;
$weight-medium              : 500;
$weight-semibold            : 600;
$weight-bold                : 700;

// Links
$link                       : $secondary;
$link-invert                : $secondary-invert;
$link-focus-border          : $secondary;

$label-weight               : $weight-light;
$modal-background-background-color: rgba(104, 103, 103, 0.1);

// input

// $input-radius               : 1.25rem;

$speed-slow: 150ms;
$speed-slower: 800ms;

//$input-radius               : 1.25rem;
$input-icon-color           : $dark;

// Margin
.mt-18 {
    margin-top: 4.5rem;
}

.max-w-2xs {
    max-width: 15rem;
}

// Import only what you need from Bulma
// // @import "~bulma/sass/utilities/_all.sass";
// // @import "~bulma/sass/base/_all.sass";
// // @import "~bulma/sass/elements/button.sass";
// // @import "~bulma/sass/elements/container.sass";
// // @import "~bulma/sass/elements/title.sass";
// // @import "~bulma/sass/form/_all.sass";
// // @import "~bulma/sass/components/navbar.sass";
// // @import "~bulma/sass/layout/hero.sass";
// // @import "~bulma/sass/layout/section.sass";

// // @import '../assets/sass/variables';
// // @import '../assets/sass/functions';
// // @import '../assets/sass/elements/table';

// // @import "~bulma/sass/layout/hero";
// @import "~bulma/sass/layout/footer";
// @import "~bulma/sass/layout/section";
// @import "~bulma/sass/grid/tiles";
// @import "~bulma/sass/elements/box";
// // @import "~bulma/sass/elements/other";
// @import "~bulma/sass/elements/notification";
// @import "~bulma/sass/components/breadcrumb";
// @import "~bulma/sass/components/dropdown";
// @import "~bulma/sass/components/level";
// @import "~bulma/sass/components/media";
// @import "~bulma/sass/components/menu";
// @import "~bulma/sass/components/navbar";
// @import "~bulma/sass/components/tabs";

// // @import '../assets/sass/components/collapse';
// // @import '../assets/sass/components/datepicker';
// // @import '../assets/sass/components/dialog';
// // @import '../assets/sass/components/loading';
// // @import '../assets/sass/components/message';
// // @import '../assets/sass/components/modal';
// // @import '../assets/sass/components/notices';
// // @import '../assets/sass/components/switch';
// // @import '../assets/sass/components/table';

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

.heroicon-outline { fill: #626262 }
.heroicon-component-fill { fill: white }
.heroicon-component-accent {fill: var(--color-tertiary) }
.heroicon-shadows {fill: #626262; opacity: .4 }
nav a.is-active{
  border-bottom-color: theme('borderColor.gray.500', currentColor);
}

</style>

<style lang="scss">
@import "~tailwindcss/base";
@import "~tailwindcss/components";
@import "~tailwindcss/utilities";

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
