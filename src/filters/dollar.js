export default function dollar (value) {
  return `$${parseFloat(value).toFixed(2)}`
}
