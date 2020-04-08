export const namespaced = true

const state = () => ({
  pledges: [],
  pledge_types: [],
  sponsor_types: [],
  ppuPledgeTypeId: 1,
  pledgeStatusIdsWithPayment: [3, 8],
  STATUS_ENTERED: 1,
  STATUS_CONFIRMED: 2,
  STATUS_PAID: 3,
  STATUS_PENDING: 4,
  STATUS_DELETED: 5,
  STATUS_CANCELLED: 6,
  STATUS_ABANDONED: 7,
  STATUS_PAYMENT_SCHEDULED: 8,
  PLEDGE_TYPE_PPL: 1,
  PLEDGE_TYPE_FLAT: 3,
})

const getters = {
  pledges: state => state.pledges,

  ppuPledgeTypeId: state => state.ppuPledgeTypeId,

  pledgeStatusIdsWithPayment: state => state.pledgeStatusIdsWithPayment,

  STATUS_ENTERED: state => state.STATUS_PENDING,
  STATUS_CONFIRMED: state => state.STATUS_PENDING,
  STATUS_PAID: state => state.STATUS_PENDING,
  STATUS_PENDING: state => state.STATUS_PENDING,
  STATUS_DELETED: state => state.STATUS_PENDING,
  STATUS_CANCELLED: state => state.STATUS_PENDING,
  STATUS_ABANDONED: state => state.STATUS_PENDING,
  STATUS_PAYMENT_SCHEDULED: state => state.STATUS_PENDING,
  PLEDGE_TYPE_PPL: state => state.STATUS_PENDING,
  PLEDGE_TYPE_FLAT: state => state.STATUS_PENDING,

  hasPaidAllPledges: getters => pledges => {
    return pledges.map(pledge => pledge.pledge_status_id)
      .flat(1)
      .every((pledgeStatusId) => getters.pledgeStatusIdsWithPayment.includes(pledgeStatusId))
  },

  pledgeTotal: () => (pledges, unit_range_low, unit_range_high) => {
    const totals = pledges.reduce(
      (totals, pledge) => {
        if (pledge.pledge_type_id === 1) {
          totals.low += pledge.amount * unit_range_low
          totals.high += pledge.amount * unit_range_high
        } else {
          totals.low += pledge.amount
          totals.high += pledge.amount
        }
        return totals
      },
      { low: 0, high: 0 },
    )
    let totalsString = totals.low
    if (totals.low !== totals.high) {
      totalsString += ' to $' + totals.high
    }
    return totalsString
  },

  isMissingPayment: () => pledges => {
    const unPaidPledge = pledges.find((pledge) => {
      return pledge.hasPendingPayment === false && pledge.payment_id === null
    })
    return unPaidPledge !== undefined
  },

  showAllStatuses: () => pledges => {
    const statuses = pledges.map(pledge => {
      return pledge.pledge_status_id
    })
    const statusSet = new Set(statuses)
    return statusSet.size > 1
  },

  pledgeProgram: (state, getters) => pledge => {
    return getters.participantById(pledge.participant_user_id).participant_info.classroom.group.program
  },

  flatPledges: () => pledges => {
    const flatPledges = []

    pledges.forEach(pledgeArray => {
      pledgeArray.forEach(pledge => {
        flatPledges.push(pledge)
      })
    })

    return flatPledges
  },

  pledgesByParticipantId: ({ getters }) => participantId => {
    const participant = getters.participantById(participantId)
    const otherParticipants = getters.otherParticipants(participantId)

    return getters.addFamilyPledgesToPledges(participant, otherParticipants)
  },
  sortPledgesByDateEntered: () => pledges => {
    return pledges.sort(function (pledgesA, pledgesB) {
      return new Date(pledgesA[0].ts_entered) - new Date(pledgesB[0].ts_entered)
    })
  },
  isFamilyPledgingEnabled: () => participant => {
    const program = participant.participant_info.classroom.group.program
    if (program.program_pledge_setting.family_pledging_enabled === 1 &&
            participant.participant_info.family_pledging_enabled === 1) {
      return true
    }

    return false
  },
  addFamilyPledgesToPledges: () => (participant, otherParticipants) => {
    const pledges = participant.participant_info.pledges

    pledges.forEach((pledge, index) => {
      pledge.amount = parseFloat(pledge.amount)
      if (pledge.family_pledge_id !== null) {
        const familyPledges = [pledge]
        otherParticipants.forEach(otherParticipant => {
          otherParticipant.participant_info.pledges.forEach(siblingPledge => {
            if (siblingPledge.family_pledge_id === pledge.family_pledge_id && siblingPledge.id !== pledge.id) {
              familyPledges.push(siblingPledge)
            }
          })
        })
        pledges.splice(index, 1, familyPledges)
      } else {
        // Put the pledge into an array to keep the format of pledges consistent
        pledges.splice(index, 1, [pledge])
      }
    })

    return pledges
  },

  getAllParticipantPledges: (state, getters, rootState, rootGetters) => {
    let pledges = []

    rootGetters['program/programs'].forEach(function (program) {
      program.participants.forEach(function (participant) {
        pledges = pledges.concat(participant.participant_info.pledges)
      })
    })

    return pledges.filter(pledge => {
      return pledge.deleted !== 1
    })
  },

  familyPledges: state => (pledges, program) => {
    if (!pledges[0].family_pledge_id) {
      const participant = program.participants.find(participant => {
        return participant.id === pledges[0].participant_user_id
      })

      return [
        participant.participant_info.pledges.find(pledge => {
          return pledge.id === pledges[0].id
        }),
      ]
    }
    const returnPledges = []
    program.participants.forEach(participant => {
      const pledge = participant.participant_info.pledges.find(pledge => { return pledge.family_pledge_id === pledges[0].family_pledge_id })
      returnPledges.push(pledge)
    })
    return returnPledges
  },
}

const mutations = {
  SET_PLEDGES: (state, pledges) => {
    state.pledges = pledges
  },
  SET_PLEDGE_TYPES (state, pledge_types) {
    state.pledge_types = pledge_types
  },
  SET_SPONSOR_TYPES (state, sponsor_types) {
    state.sponsor_types = sponsor_types
  },
}

const actions = {
  deletePledge ({ getters, commit }, pledgeId) {
    const participants = getters.participants

    participants.forEach(participant => {
      participant.participant_info.pledges.forEach((pledgeArray, pledgeArrayIndex) => {
        pledgeArray.forEach((pledge, index) => {
          if (pledge.id === pledgeId) {
            pledgeArray.splice(index, 1)
          }
        })
        if (pledgeArray.length === 0) {
          participant.participant_info.pledges.splice(pledgeArrayIndex, 1)
        }
      })
    })

    commit('SET_PARTICIPANTS', participants)
  },
}

// export const actions = {
//     deletePledge (state, pledge) {
//         let programs = state.user.programs.filter(program => {
//             return pledge.program_id === program.id;
//         });

//         programs.forEach(program => {
//             program.participants.forEach(participant => {
//                 for (let i = 0; i < participant.participant_info.pledges.length; i++) {
//                     let participantPledge = participant.participant_info.pledges[i];

//                     if ((participantPledge.family_pledge_id !== null && participantPledge.family_pledge_id === pledge.family_pledge_id) || participantPledge.id === pledge.id) {
//                         participant.participant_info.pledges.splice(i, 1);
//                     }
//                 }
//             });
//         });

//         state.user = {...state.user};
//         // commit('DELETE_PLEDGE', )
//     }
// };

export default {
  namespaced,
  state,
  getters,
  mutations,
  actions,
}
