import ClipboardJS from 'clipboard'
class ClickToCopy {
  static enable () {
    $(document).ready(() => {
      const clipboardjs = new ClipboardJS('.copy-text')

      clipboardjs.on('success', (event) => {
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
