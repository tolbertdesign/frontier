import ClipboardJS from 'clipboard'

class ClickToCopy {
  static enable () {
    $(document).ready(function () {
      const clipboard = new ClipboardJS('.copy-text')

      clipboard.on('success', function (event) {
        $('.copy-text').tooltip({ trigger: 'manual' })
        $(event.trigger).tooltip('show')
        setTimeout(function () {
          $(event.trigger).tooltip('hide')
        }, 1000)
      })
    })
  }
}
export default ClickToCopy
