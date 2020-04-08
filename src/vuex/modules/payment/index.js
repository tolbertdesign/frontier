export const namespaced = true

const state = () => ({
  STATUS_PENDING: 1,
  STATUS_PROCESSING: 2,
  STATUS_PAID: 3,
  STATUS_DENIED: 4,
})

const getters = {
  STATUS_PENDING: state => state.STATUS_PENDING,
  STATUS_PROCESSING: state => state.STATUS_PROCESSING,
  STATUS_PAID: state => state.STATUS_PAID,
  STATUS_DENIED: state => state.STATUS_DENIED,
  STATUS_PAYMENT_SCHEDULED: state => {
    return [
      state.STATUS_PENDING,
      state.STATUS_PROCESSING,
      state.STATUS_PAID,
    ]
  },
}

export default {
  state,
  getters,
}
