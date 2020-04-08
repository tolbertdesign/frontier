<template>
  <div
    id="titan-app"
    class="min-h-screen flex items-center justify-center bg-cover bg-center"
    style="background-image: url('/img/titan_landing_page_bg.jpg')"
  >
    <div class="w-128 pt-6 pb-16 bg-gray-100 text-center shadow-lg rounded">
      <h1 class="mb-2 text-6xl leading-none">
        Welcome!
      </h1>

      <p class="max-w-xs mx-auto mb-8 font-light px-8 text-lg">
        Becoming a fundraising hero is now easier than ever.
      </p>
      <p class="mb-4 text-sm font-medium leading-none">
        Get started here
      </p>
      <div class="flex flex-col items-center justify-center">
        <button class="w-48 mb-6 py-2 inline-block font-bold rounded-full shadow border-2 border-blue-500 text-white bg-blue-500 hover:bg-blue-400 active:bg-blue-600">
          I’m a Parent
        </button>
        <button class="w-48 mb-6 py-2 inline-block font-bold rounded-full shadow border-2 border-green-500 text-white bg-green-500 hover:bg-green-400 active:bg-green-600">
          I’m a Teacher
        </button>
        <button class="w-48 py-2 inline-block font-bold rounded-full shadow border-2 border-black text-black bg-gray-100 hover:bg-white active:bg-gray-200">
          I’m a Sponsor
        </button>
        <div class="w-48 is-divider" data-content="OR" />
        <button class="w-48 py-2 inline-block font-bold rounded-full shadow-lg border bg-white">
          Login
        </button>
      </div>

      <!-- We use cookies to help make Boosterthon better. By visiting this site, you agree to our cookie policy
      Need Help? | Español? | Privacy Policy -->
    </div>
  </div>
</template>

<script>
export default {
  name: 'TitanLandingIndex',
}
</script>

<style lang="sass">
$divider-background-color: $grey-lighter !default
$divider-thickness: .1rem !default
$divider-font-size: $size-7 !default
$divider-content-background-color : $white !default

$divider-font-size: $size-7
$divider-color: $grey-light
$divider-content-background-color : #f7fafc

.is-divider, .is-divider-vertical
  display: block
  position: relative
  border-top: $divider-thickness solid divider-background-color
  height: $divider-thickness
  margin: 2rem 0
  text-align: center

.is-divider[data-content]::after, .is-divider-vertical[data-content]::after
  background: $divider-content-background-color
  color: $divider-color
  content: attr(data-content)
  display: inline-block
  font-size: $divider-font-size
  font-weight: 700
  padding: .4rem .8rem
  -webkit-transform: translateY(-1.1rem)
  -ms-transform: translateY(-1.1rem)
  transform: translateY(-1.1rem)
  text-align: center</style>
