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
    const category = node.attr('data-category')
      ? node.attr('data-category')
      : 'share button'
    const action = node.attr('data-action')
      ? node.attr('data-action')
      : 'click'
    const label = node.attr('data-share')
    /**
     * TODO Add global $ga helper to the Vue.prototype
     * TODO Document the others
     * - this.$t
     * - this.$ga
     * - this.$http (convenient wrapper for global XHR (axios) requests
     * - this.$axon (specialized for calling our backend resources)
     * - this.$router (access router globally)
     * - this.$store (access store globally)
     * - this.$buefy (access buefy components (modal, toast, etc...)
     */

    ga('send', 'event', category, action, label, null)
  }
}

export default GoogleAnalytics
