export default {
  methods: {
    gaEvent: (category, label, action) => {
      if (gtag !== undefined) {
        gtag('event', action, { event_category: category, event_label: label })
      }
    },
  },
}
