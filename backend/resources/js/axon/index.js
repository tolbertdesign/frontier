// axios instance
import axios from 'axios'
import { ToastProgrammatic as Toast } from 'buefy'

import store from '@/store/index'

// Laravel CSRF token
const token = document.head.querySelector('meta[name="csrf-token"]')

// Create an Instance
const instance = axios.create({
  // change this url to your api
  baseURL: '//' + window.location.hostname + '/',
  // any other headers you want to include
  headers: {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': token ? token.content : null,
  },
})

function hideDefaultLoading () {
  document.querySelector('#default-loading').classList.add('hidden')
}

// Set default loading function
instance.interceptors.request.use(function (request) {
  // Callback for the request
  if (request.loading && typeof (request.loading) === 'function') {
    request.loading()
  } else {
    // Do default loading here
    document.querySelector('#default-loading').classList.remove('hidden')
  }

  return request
})

// Error interceptor can be used for global error handling
instance.interceptors.response.use(function (response) {
  // Hide default loading HTML
  hideDefaultLoading()

  return response
}, function (error) {
  if (error.config.error && typeof (error.config.error) === 'function') {
    hideDefaultLoading()
    error.config.error(error)
  } else {
    hideDefaultLoading()
    Toast.open(store.getters.lang.default_error)
  }

  // Reject promise and throw an error
  return Promise.reject(error)
})

// Define RESTful endpoints for the resources with a callback for the loading state
// Note: Eloquent ORM naming conventions were used
export default {
  get: (resource, loading, error) => {
    return instance.get(`/v3/api/${resource}`, {
      loading: loading,
      error: error,
    })
  },
  find: (resource, id, loading, error) => {
    return instance.get(`/v3/api/${resource}/${id}`, {
      loading: loading,
      error: error,
    })
  },
  create: (resource, item, loading, error) => {
    return instance.post(`/v3/api/${resource}`, item, {
      loading: loading,
      error: error,
    })
  },
  update: (resource, id, item, loading, error) => {
    return instance.put(`/v3/api/${resource}/${id}`, item, {
      loading: loading,
      error: error,
    })
  },
  delete: (resource, id, loading, error) => {
    return instance.delete(`/v3/api/${resource}/${id}`, {
      loading: loading,
      error: error,
    })
  },
}
