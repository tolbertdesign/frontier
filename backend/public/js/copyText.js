$('.copy-text').tooltip({ trigger: 'manual' })

$('.copy-text').on('click', function () {
    let that = this
    that.select()
    document.execCommand('Copy')
    $(that).tooltip('show')
    setTimeout(() => {
        $(that).tooltip('hide')
    }, 1000)
})
