class Facebook {
  enable () {
    $(document).ready(_.bind(function () {
      const that = this
      $('.facebook-share-btn').click(e => {
        const theButton = $(e.currentTarget)
        const title = theButton.attr('data-title')
        const desc = theButton.attr('data-desc')
        const url = theButton.attr('data-url')
        const image = theButton.attr('data-image')
        that.shareOnFacebook(title, desc, url, image)
      })
    }, this))
  }

  shareOnFacebook (title, desc, url, image) {
    FB.ui({
      method: 'share',
      href: url,
    })
  }
}

export default Facebook
