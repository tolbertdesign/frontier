    function tidyUpAnimations () {
      // eslint-disable-next-line
      console.log('tidying up...')
    }

    // Get the first position.
    const first = this.$el.getBoundingClientRect()
    // eslint-disable-next-line
    console.log('first: ', first)

    // Now set the element to the last position.
    this.$el.classList.add('transform translate-y-12 duration-500 ease-in')
    // eslint-disable-next-line
    console.log(this.$el)

    // Read again. This forces a sync
    // layout, so be careful.
    const last = this.$el.getBoundingClientRect()
    // eslint-disable-next-line
    console.log('last: ', last)

    // You can do this for other computed
    // styles as well, if needed. Just be
    // sure to stick to compositor-only
    // props like transform and opacity
    // where possible.
    const invert = first.top - last.top

    // Invert.
    this.$el.style.transform = `translateY(${invert}px)`

    // Wait for the next frame so we
    // know all the style changes have
    // taken hold.
    requestAnimationFrame(() => {
      // Switch on animations.
      this.$el.classList.add('animate-on-transforms')

      // GO GO GOOOOOO!
      this.$el.style.transform = ''
    })

    // Capture the end with transitionend
    this.$el.addEventListener('transitionend', tidyUpAnimations)

    //  Go from the inverted position to last.
    // var player = this.$el.animate([
    //   { transform: `translateY(${invert}px)` },
    //   { transform: 'translateY(0)' },
    // ], {
    //   duration: 300,
    //   easing: 'cubic-bezier(0,0,0.32,1)',
    // })

    // // Do any tidy up at the end
    // // of the animation.
    // player.addEventListener('finish', tidyUpAnimations)
