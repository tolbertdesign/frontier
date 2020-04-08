import ClipboardJS from 'clipboard'
class ClickToCopy {
  static enable () {
    $(document).ready(function () {
      var clipboardjs = new ClipboardJS('.copy-text')
      clipboardjs.on('success', function (e) {
        $('.copy-text').tooltip({ trigger: 'manual' })
        $(e.trigger).tooltip('show')
        setTimeout(function () {
          $(e.trigger).tooltip('hide')
        }, 1000)
      })
    })
  }
}
export default ClickToCopy
