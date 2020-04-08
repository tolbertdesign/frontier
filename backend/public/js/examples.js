console.clear()
function getStyle (element, style, no) {
  return window.getComputedStyle(element).getPropertyValue(style)
}

// Animation Examples
var demo1 = document.querySelector('.demo1')
var demo2 = document.querySelector('.demo2')
var demo3 = document.querySelector('.demo3')

function popSwitcher (el, emphasis = '') {
  el.addEventListener('click', function () {
    if (this.classList.contains('pop')) {
      this.classList.remove('pop', 'entrance' + emphasis)
      this.classList.add('unpop', 'exit' + emphasis)
    } else {
      this.classList.remove('unpop', 'exit' + emphasis)
      this.classList.add('pop', 'entrance' + emphasis)
    }
  }, false)
}

popSwitcher(demo1)
popSwitcher(demo2, '-emphasis')
popSwitcher(demo3, '-emphasis')

// const asyncFunction = async () => {
//   const promise1Result = await promsise1
//   const promise2Result = await promsise2
// }

// const asyncFunction = () => {
//   promise1.then((promise1Result) => {
//     return promise2
//   }).then((promise2Result) => {
//     console.log(promise2Result);
//   })
// }
