class Facebook {
  enable () {
    $(document).ready(_.bind(function () {
      const self = this

      $('.facebook-share-btn').click(event => {
        const theButton = $(event.currentTarget)
        const title = theButton.attr('data-title')
        const desc = theButton.attr('data-desc')
        const url = theButton.attr('data-url')
        const image = theButton.attr('data-image')
        self.shareOnFacebook(title, desc, url, image)
      })
    }, this))
  }

  shareOnFacebook (title, desc, url, image) {
    const userId = $('input[name="participant_user_id"]').val()

    FB.ui({
      method: 'share',
      href: url,
    },
    function (response) {
      if (response && !response.errorMessage) {
        $.get('/users/user_successful_facebook_share/' + userId,
          { data: 'success' }, function (data) {
            return data
          })
      }
    })
  }
}

export default Facebook
