class GoogleAnalytics {
  enable () {
    $(document).ready(_.bind(this.attachGoogleAnalyticsClickHandlers, this))
  }

  attachGoogleAnalyticsClickHandlers () {
    var selector = '.ga_track[data-share]'
    $('body').on('click', selector, this.determineElementCategoryAndReport)
  }

  determineElementCategoryAndReport () {
    var node = $(this)
    var category = node.attr('data-category') ? node.attr('data-category') : 'share button'
    var action = node.attr('data-action') ? node.attr('data-action') : 'click'
    var label = node.attr('data-share')
    ga('send', 'event', category, action, label, null)
  }
}

module.exports = GoogleAnalytics
