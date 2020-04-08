$(document).ready(function () {
  const trigger = $('.hamburger')
  const overlay = $('.overlay')
  const isClosed = false

  trigger.click(function () {
    hamburgerToggle()
  })

  $('[data-toggle="offcanvas"]').click(function () {
    $('#wrapper').toggleClass('toggled')
  })

  function hamburgerToggle () {
    if (isClosed === true) {
      overlay.hide()
      trigger.removeClass('is-open')
      trigger.addClass('is-closed')
      isClosed = false
    } else {
      overlay.show()
      trigger.removeClass('is-closed')
      trigger.addClass('is-open')
      isClosed = true
    }
  }
})
