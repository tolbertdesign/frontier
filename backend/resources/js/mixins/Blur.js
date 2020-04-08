export default {
  methods: {
    blur () {
      document.getElementById('app').style.filter = 'blur(4px)'
    },
    unBlur () {
      document.getElementById('app').style.filter = 'none'
    },
  },
}
