export default {
  methods: {
    participantDisplayNames (participants) {
      if (participants.length === 1) {
        return participants[0].first_name
      }
      if (participants.length === 2) {
        return participants[0].first_name + ' & ' + participants[1].first_name
      }
      const names = participants.map(function (participant) {
        return participant.first_name
      })
      const last = names.pop()
      return names.join(', ') + ' & ' + last
    },
  },
}
