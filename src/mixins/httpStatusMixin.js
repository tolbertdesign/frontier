export const HTTPStatusMixin = {
  created () {
    if (this.$ssrContext && this.$options.HTTPStatus) {
      this.$ssrContext.HTTPStatus = this.$options.HTTPStatus
    }
  },
}
