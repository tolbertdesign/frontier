<template>
  <CookieConsent>
    <template slot="message">
      <div class="flex items-center text-sm">
        <i18n path="cookie_consent_message">
          <v-popover
            class="inline"
            content="content"
            placement="top"
            arrow
            popover-class="w-full max-w-xs focus:outline-none focus:shadow-outline"
          >
            <button class="font-bold border-b border-blue-500 border-dotted focus:outline-none">
              {{ $t('cookie_policy') }}
            </button>
            <template slot="popover">
              <p>{{ $t('about_cookies') }}</p>
            </template>
          </v-popover>
        </i18n>
      </div>
    </template>
    <template slot="button">
      <button class="px-6 py-1 text-sm text-white bg-blue-600 rounded-full focus:outline-none focus:shadow-outline">
        Got it
      </button>
    </template>
  </CookieConsent>
</template>

<script>
import CookieConsent from 'vue-cookieconsent-component'

export default {
  name: 'AppCookieConsent',
  components: { CookieConsent },
}
</script>

<style lang="scss">
$cookieconstent-padding: 1rem 1.5rem;
$cookieconstent-space: .7rem;
$cookieconstent-compliance-padding: .5rem 2rem;
$cookieconstent-background: #ced4da;
$cookieconstent-compliance-padding: .5rem 2rem;
$cookieconstent-compliance-color: #fff;
$cookieconstent-compliance-background: #237afc;
$cookieconstent-compliance-border: 2px solid currentColor;
@import "~vue-cookieconsent-component/src/scss/cookie-consent";
@import "~vue-cookieconsent-component/src/scss/cookie-consent-bottom";
@import "~vue-cookieconsent-component/src/scss/cookie-consent-transition";
.cookie-consent { @apply justify-between }
</style>

<style lang="scss">
$cookieconstent-padding: 1rem 0;
$cookieconstent-space: .5rem 1rem;
$cookieconstent-position: fixed;
$cookieconstent-background: #ced4da;
$cookieconstent-z-index: 9999;
$cookieconstent-width: 100%;

$cookieconstent-compliance-padding: .5rem 2rem;
$cookieconstent-compliance-color: #fff;
$cookieconstent-compliance-background: #237afc;
$cookieconstent-compliance-border: 2px solid currentColor;

.cookie-consent {
  position: $cookieconstent-position;
  z-index: $cookieconstent-z-index;
  width: $cookieconstent-width;
  padding: $cookieconstent-padding;

  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: center;

  background: $cookieconstent-background;

  &-message,
  &-compliance {
    margin: $cookieconstent-space;
  }

  &-compliance {
    cursor: pointer;
    color: $cookieconstent-compliance-color;
    padding: $cookieconstent-compliance-padding;
    background: $cookieconstent-compliance-background;
    border: $cookieconstent-compliance-border;
  }
}
</style>

<style lang="scss">
.cookie-consent {
  position: sticky;
  @apply w-full py-4 z-10 flex items-center justify-center bg-red-900 text-red-200 text-xs;

  &-link {
    @apply text-red-100 underline;

    &:hover {
      @apply no-underline;
    }
  }

  &-message,
  &-compliance {
    @apply mx-2 my-1 px-2;

    @screen md {
      @apply px-4;
    }
  }

  &-compliance {
    @apply cursor-pointer text-white py-2 rounded border-white border;

    &:hover {
      @apply bg-white text-black;
    }
  }

  @screen md {
    @apply text-sm text-center;
  }
}
</style>
