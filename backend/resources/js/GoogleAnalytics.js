class GoogleAnalytics {
  enable () {
    $(document).ready(_.bind(this.attachGoogleAnalyticsClickHandlers, this))
  }

  attachGoogleAnalyticsClickHandlers () {
    const selector = '.ga_track[data-share]'
    $('body').on('click', selector, this.determineElementCategoryAndReport)
  }

  determineElementCategoryAndReport () {
    const node = $(this)
    const label = node.attr('data-share')
    const category = node.attr('data-category')
      ? node.attr('data-category')
      : 'share button'
    const action = node.attr('data-action')
      ? node.attr('data-action')
      : 'click'
    ga('send', 'event', category, action, label, null)
  }
}

module.exports = GoogleAnalytics
