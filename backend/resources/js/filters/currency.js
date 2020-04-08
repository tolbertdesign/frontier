export default function currency (val, addCommas, currencySymbol) {
  let value = parseFloat(val)
  if (Math.floor(value) === value) {
    value = value.toFixed(0)
  } else {
    value = value.toFixed(2)
  }

  if (typeof (addCommas) !== 'undefined' && addCommas) {
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',')
  }

  if (typeof (currencySymbol) !== 'undefined') {
    value = currencySymbol + value
  }

  return value
}
