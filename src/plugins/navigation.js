$(document).ready(function () {
  const trigger = $('.hamburger')
  const overlay = $('.overlay')
  let isClosed = false

  trigger.click(function () {
    hamburgerCross()
  })

  function hamburgerCross () {
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

  $('[data-toggle="offcanvas"]').click(function () {
    $('#wrapper').toggleClass('toggled')
  })
})
