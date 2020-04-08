module.exports = function zerofill (value) {
  // value = ( value < 0 ? 0 : value );
  return (value < 10 && value > -1 ? '0' : '') + value
}
