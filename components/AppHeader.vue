<template>
  <header
    class="fixed z-20 app-header"
    :style="`background-color:${$store.state.program.microsite.microsite_color_theme.hex_code}`"
  >
    <div class="container">
      <router-link
        class="flex-shrink-0 border-transparent"
        :to="{name: 'give'}"
      >
        <img v-if="hasLogo" :src="logoUrl" :alt="title" class="logo" />
      </router-link>

      <h1>
        {{ title }}
      </h1>
    </div>
  </header>
</template>

<script>
export default {
  name: 'AppHeader',
  props: {
    title: {
      type: String,
      default: null,
    },
    logoUrl: {
      type: String,
      default: null,
    },
  },
  computed: {
    hasLogo() {
      return !!this.logoUrl
    },
  },
}
</script>

<style>
.app-header {
  @apply w-full;
  @apply text-white;
  @apply bg-cover;
  @apply bg-center;
  @apply shadow;
  @apply text-white;
  @apply mb-5;
}

.app-header .container {
  @apply flex items-center;
  @apply w-full;
  @apply max-w-4xl;
  @apply mx-auto;
  @apply py-4 px-6;
  @apply bg-transparent;
}
.app-header .logo {
  @apply w-16 h-16;
  @apply mb-0 mr-8;
  @apply rounded-full;
  @apply shadow-md;
}

.app-header h1 {
  @apply text-xl font-medium leading-tight;
}

@screen sm {
  .app-header h1 {
    @apply text-2xl;
  }
}

@screen lg {
  .app-header .container {
    @apply px-0;
  }

  .app-header .logo {
    @apply w-24 h-24;
  }

  .app-header h1 {
    @apply text-4xl;
  }
}
</style>
