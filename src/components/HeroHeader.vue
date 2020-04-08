<template>
  <header>
    <section class="header-content">
      <img
        class="rocky-dashed animate-pop-in"
        src="/img/rocky-dashed.svg"
      >
      <h1 class="header-title animate-pop-in">
        Ecco (ERS For Public Health)
      </h1>
      <h3 class="header-subtitle animate-pop-in">
        <span>Powerful, Flexible, Scale-able, Collaboration, data capture and reporting system. For Technical Assistance and Proaress Reporting</span>
        <span>It's 10am do you what your numbers are?</span>
      </h3>
      <p class="header-button animate-pop-in">
        <a href="#calls-to-action" class="button">Get started today</a>
      </p>
    </section>
    <section class="header-down-arrow">
      <img src="/img/downarrow.png" width="50">
    </section>
  </header>
</template>

<script>
export default {
  name: 'HeroHeader',
  mounted () {
    document.body.className += ' js-loading'
    window.addEventListener('load', showPage, false)
    function showPage () {
      document.body.className = document.body.className.replace('js-loading', '')
    }
  },
}
</script>

<style lang="postcss">
header {
  align-items: center;
  display: flex;
  font-size: 18px;
  height: 100vh;
  justify-content: center;
  overflow: hidden;
  position: relative;
  text-align: center;
  transform-style: preserve-3d;
  perspective: 100px;
}

header:before {
  /* animation: fade-slide-down 2s .5s cubic-bezier(0, 0.5, 0, 1) forwards; */
  animation: no-transform 2s .5s cubic-bezier(0, 0.5, 0, 1) forwards;
  background: linear-gradient(to bottom, rgba(0,0,0,0), rgba(0,0,0,.8)),
              url(https://images.unsplash.com/photo-1446776811953-b23d57bd21aa?dpr=2&auto=format&fit=) no-repeat bottom;
  background-size: cover;
    bottom: 0;
  content: "";
    left: 0;
  opacity: 0;
  position: absolute;
    right: 0;
    top: 0;
  z-index: -1;
}

header:after {
  background: #F9FCFF;
  content: "";
  height: 40rem;
  left: -5%;
  position: absolute;
    right: -5%;
    top: 90%;
  transform: rotateZ(-4deg);
  transform-origin: 0 0;
  z-index: 0;
}

.rocky-dashed { animation-delay: .6s }
.header-title { animation-delay:.8s }
.header-subtitle { animation-delay: 1s }
.header-button { animation-delay: 1.1s }
.header-down-arrow {
  animation: pulse 2s 3s ease-out infinite;
  bottom: 4vh;
  left: 0;
  position: absolute;
  right: 0;
  text-align: center;
  z-index: 10;
}
.header-down-arrow img {
  /* animation: fade-slide-up 1s 1s ease-out forwards; */
  animation: no-transform 1s 1s ease-out forwards;
  opacity: 0;
}
</style>
