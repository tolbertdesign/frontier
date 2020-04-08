const axios = require('axios')
const apiUrl = 'http://localhost:3000'

export const contactMixin = {
  methods: {
    getContacts () {
      return axios.get(`${apiUrl}/contacts`)
    },
    addContact (data) {
      return axios.post(`${apiUrl}/contacts`, data)
    },
    updateContact (data, id) {
      return axios.put(`${apiUrl}/contacts/${id}`, data)
    },
    deleteContact (id) {
      return axios.delete(`${apiUrl}/contacts/${id}`)
    },
  },
}
