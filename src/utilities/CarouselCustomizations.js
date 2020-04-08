class CarouselCustomizations {
  enable () {
    $(document).ready(_.bind(this.attachMultipleTargetNav, this))
  }

  attachMultipleTargetNav () {
    const selector = '.nav-multiple-targets'
    $('body').on('click', selector, this.fireMultipleTargetNav)
  }

  fireMultipleTargetNav (event) {
    event.preventDefault()
    $($(this).data('target')).carousel($(this).data('slide'))
  }
}

export default CarouselCustomizations
