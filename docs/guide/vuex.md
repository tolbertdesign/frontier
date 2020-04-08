---
title: Vuex
lang: en-US
---

## Directory Structure

<!-- textlint-disable terminology -->
```
├── vuex
│   ├── modules
│   │   ├── classroom
│   │   ├── emailer
│   │   ├── message
│   │   ├── microsite
│   │   ├── notification
│   │   ├── participant
│   │   ├── payment
│   │   ├── pledge
│   │   ├── program
│   │   ├── sponsor
│   │   └── user
│   └── store.js
```
<!-- textlint-enable -->

## Vuex Root

### `@/vuex/store`

```js
import lang from '@/vuex/modules/lang'
import user from '@/vuex/modules/user'
import participant from '@/vuex/modules/participant'
import program from '@/vuex/modules/program'
import pledge from '@/vuex/modules/pledge'
import notification from '@/vuex/modules/notification'
import classroom from '@/vuex/modules/classroom'
```

#### State

::: details state
```js
export const state = {
  lang: Object,
  s3Bucket: '',
  minPasswordLength: 0,
  contentGroup: '',
  activeTab: 0,
  states: [],
  countries: [],
  forcePageRouteRefresh: false,
}
```
:::

#### Getters

```js
export const getters = {
  activeTab: state => state.activeTab
}
```

#### Actions

::: details actions
```js
export const actions = {
  init: ({ dispatch }, user) => {
    dispatch('participant/initParticipantsAndPledges', user.participants)
    dispatch('program/initPrograms', user.participants)
    dispatch('classroom/initClassrooms')
  },
  setContentGroup: ({ state, commit }, route) => {
    if (state.contentGroup !== route.name) {
      gtag('config', 'UA-18391724-4', {
        'page_title': route.name,
        'page_path': route.path,
        'content_group1': route.name
      });
      commit('SET_CONTENT_GROUP', route.name)
  }
  },
  setActiveTab: ({ commit }, index) => {
    commit('SET_ACTIVE_TAB', index)
  }
}
```
:::

## Vuex Modules

### `@/vuex/modules/classroom`

#### State

::: details state
```js
export const state = {
  classrooms: [],
}
```
:::

#### Getters

::: details getters
```js
export const getters = {
  getClassrooms: state => state.classrooms,

  getClassroom: state => id => state.classrooms.find(classroom => classroom.id === id),

  getClassroomsByGrade: getters => {
    return getters.getClassrooms.filter(classroom => !classroom.deleted)
      .reduce((classrooms, classroom) => {
        let grade = (classroom.grade.id > 0) ? `${classroom.grade.name} Grade` : classroom.grade.name
        if (!classrooms[grade]) {
          classrooms[grade] = []
        }
        classrooms[grade].push(classroom)
        return classrooms
      }, {})
  },
}
```
:::

#### Actions

::: details actions
```js
export const actions = {
  initClassrooms: ({ commit, rootGetters }) => {
    let currentClassrooms = [];

    rootGetters['program/getPrograms'].forEach(program => {
      program.classrooms.forEach(programClassroom => {
        let classroomCheck = currentClassrooms.find(classroom => classroom.id === programClassroom.id)
        if (classroomCheck === undefined) {
          currentClassrooms.push(programClassroom)
        }
      })
    })

    commit('SET_CLASSROOMS', currentClassrooms)
  }
}
```
:::

### `@/vuex/modules/emailer`

```js
import FamilyPledging from '@/utilities/FamilyPledging'

```

#### State

::: details state
```js
export const state = {
  contacts: [],
}
```
:::

#### Getters

::: details getters
```js
export const getters = {
  getParticipantForPreviousSponsors: (state, getters, rootGetters) => (participantId) => {
    // let participantId = parseInt(router.currentRoute.params.participantUserId);
    if (typeof participantId === 'undefined' || participantId === null || isNaN(participantId)) {
      // Default to the first participant a parent has.  
      participantId = getters.getActivePrograms[rootGetters.activeTab]
        .participants
        .reduce((min, current) => min.id < current.id ? min : current)
        .id;
    }
    let familyPledgingObj = getters.getFamilyPledgingObj(participantId)

    if (familyPledgingObj.isFamilyPledgingEnabled() && familyPledgingObj.getSmallestIdParticipantInCurrentParticipantProgram()) {
      return familyPledgingObj.getSmallestIdParticipantInCurrentParticipantProgram()
    } else if (familyPledgingObj.getCurrentParticipant()) {
      return familyPledgingObj.getCurrentParticipant()
    } else {
      return null
    }
  },
  getCurrentSponsorEmails: (state, getters) => {
    let pledges = getters.getAllParticipantPledges
    let currentSponsorEmails = []
    var participantProgram = getters.participantProgram
    pledges.forEach(pledge => {
      let isCurrentSponsor = pledge.program_id === participantProgram.id && pledge.participant_user_id === getters.participantForPreviousSponsors.participant_info.user_id

      if (isCurrentSponsor) {
        currentSponsorEmails.push(pledge.pledge_sponsor.email)
      }
    })

    return currentSponsorEmails
  },
  getPreviousSponsors: (state, getters) => {
    let pledges = getters.getAllParticipantPledges
    var participantProgram = getters.participantProgram
    let currentSponsorEmails = getters.getCurrentSponsorEmails

    // Filter out previous sponsors who are not also current sponsors
    pledges = pledges.filter(pledge => {
      let isCurrentSponsor = pledge.program_id === participantProgram.id && pledge.participant_user_id === getters.participantForPreviousSponsors.participant_info.user_id

      return !isCurrentSponsor && currentSponsorEmails.indexOf(pledge.pledge_sponsor.email) === -1
    })

    return pledges.map(pledge => {
      let optOut;

      if (pledge.pledge_sponsor.user && pledge.pledge_sponsor.user.id) {
        optOut = pledge.pledge_sponsor.email_opt_out.length > 0 || pledge.pledge_sponsor.user.email_opt_out
      } else {
        optOut = pledge.pledge_sponsor.email_opt_out.length > 0
      }

      return {
        ...pledge.pledge_sponsor,
        isSelected: true,
        isPreviousSponsor: true,
        optOut: optOut,
      }
    })
  },

  getFamilyPledgingObj: state => participantId => {
    return new FamilyPledging(state.auth.user.programs, participantId)
  }
}
```
:::

#### Actions

::: details actions
```js
export const actions = {
  addPotentialSponsor ({ getters }, contact) {
    const participant = getters.participantForPreviousSponsors;
    participant.participant_info.potential_sponsors.push(contact)
  },

  removeContact: ({state, dispatch, getters}, {contact}) => {
    const requestParameters = {
      email: contact.email,
      participantUserId: getters.participantForPreviousSponsors.participant_info.user_id
    }
    this.$axios.post('/v3/api/delete-contact', requestParameters)
      .then(() => {
        const participant = getters.participantForPreviousSponsors
        if (contact.isPreviousSponsor) {
          // to delete a previous sponsor we create a deleted potential sponsor for the previous sponsor
          dispatch('addPotentialSponsor', {
            firstName: contact.first_name,
            lastName: contact.last_name,
            email: contact.email,
            deleted: 1,
            participantUserId: participant.participant_info.user_id,
            sponsorUserId: contact.user.id,
            enrollment: 0,
            dayBeforeRun: 0,
            dayAfterRun: 0,
            senderUserId: state.user.id,
            optOut: 0,
            emailOptOut: [],
          });
        } else {
          participant.participant_info.potential_sponsors.map(potentialSponsor => {
            if (contact.email === potentialSponsor.email) {
              potentialSponsor.deleted = 1
            }
          })
        }
    })
  }
}
```
:::

### `@/vuex/modules/microsite`

#### State

::: details state
```js
export const state = {
  microsite: {},
}
```
:::

#### Getters

::: details getters
```js
export const getters = {
  getMicrositeByProgramId: getters => programId => {
    return getters.programs.find(program => program.id === programId).microsite;
  }
}
```
:::

#### Actions

::: details actions
```js
export const actions = {}
```
:::

### `@/vuex/modules/notification`

#### State

::: details state
```js
export const state = {
  classrooms: [],
}
```
:::

#### Getters


::: details getters
```js
export const getters = {
  TYPES: state => {
    return [
      state.TYPE_PROGRAM
    ];
  },
  programNotifications: state => programId => {
    return state.notifications.filter(notification => notification.program_id === programId);
  },
  notificationsOutsideOfProgram: state => programId => {
    return state.notifications.filter(notification => notification.program_id !== programId);
  },
  unReadNotificationsByProgram: (state, getters) => programId => {
    return getters.programNotifications(programId).filter(notification => !getters.isRead(notification));
  },
  unReadNotifications: (state, getters) => {
    return state.notifications.filter(notification => !getters.isRead(notification));
  },
  isRead: state => notification => {
    return notification.read_at !== null;
  },
  programHasNotifications: (state, getters) => programId => {
    return getters.programNotifications(programId).length > 0;
  },
  sortNotificationsByProgramId: (state, getters) => programId => {
    const programNotifications = getters.programNotifications(programId);
    const otherNotifications = getters.notificationsOutsideOfProgram(programId);

    return programNotifications.concat(otherNotifications);
  }
}
```
:::

#### Actions

::: details actions
```js
export const actions = {
  readNotification ({ state, commit }, notification) {
    if (notification.read_at === null) {
      let stateNotifications = state.notifications

      stateNotifications.forEach(stateNotification => {
        if (stateNotification.id === notification.id) {
          stateNotification.read_at = new Date()
        }
      })
      // eslint-disable-next-line
      axon.update('users/notifications', notification.id, notification, () => {}, () => {})
        .catch(error => console.log(error))

      commit('SET_NOTIFICATIONS', stateNotifications);
    }
  },
  setNotifications ({ commit }, notifications) {
    commit('SET_NOTIFICATIONS', notifications)
  }
}
```
:::

### `@/vuex/modules/participant`

#### State

::: details state
```js
export const state = {
  classrooms: [],
}
```
:::

#### Getters

::: details getters
```js
export const getters = {}
```
:::

#### Actions

::: details actions
```js
export const actions = {}
```
:::

### `@/vuex/modules/payment`

#### State

::: details state
```js
export const state = {
  STATUS_PENDING: 1,
  STATUS_PROCESSING: 2,
  STATUS_PAID: 3,
  STATUS_DENIED: 4,
}
```
:::

#### Getters

::: details getters
```js
export const getters = {
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
  }
}
```
:::

#### Actions

::: details actions
```js
export const actions = {}
```
:::

### `@/vuex/modules/pledge`

#### State

::: details state
```js
export const state = {
  classrooms: [],
}
```
:::

#### Getters

::: details getters
```js
export const getters = {}
```
:::

#### Actions

::: details actions
```js
export const actions = {
  deletePledge ({ getters, commit }, pledgeId) {
    let participants = getters.participants

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
  }
}
```
:::


### `@/vuex/modules/program`

#### State

::: details state
```js
export const state = {
  classrooms: [],
}
```
:::

#### Getters


::: details getters
```js
export const getters = {
  getPrograms: state => state.programs,

  getActivePrograms: (state, getters, rootState) => {
    return getters.programs.filter(program => {
      return program.archived === 0 && program.deleted === 0
    })
  },

  getProgram: state => id => {
    return state.programs.find(program => program.id === id)
  },

  getProgramForParticipant: () => participant => {
    return participant.participant_info.classroom.group.program
  },

  getParticipantsInProgram: getters => programId => {
    return getters.participants.filter(participant => {
      return participant.participant_info.classroom.group.program === programId
    })
  }
  // FIXME  Migrate from rootState
  // programParticipantCount: ({ user: { programs } }) => (programId) => {
  //     return programs.filter(program => program.id === programId)
  //         .map(program => program.participants)
  //         .flat()
  //         .length
  // }
}
```
:::

#### Actions

::: details actions
```js
export const actions = {
  initPrograms: ({ commit, rootGetters }) => {
    let programs = []

    rootGetters['participant/participants'].forEach(participant => {
      let programId = participant.participant_info.classroom.group.program_id

      let program = programs.find(program => program.id === programId)

      if (program === undefined || !participant.participant_info.family_pledging_enabled) {
          program = participant.participant_info.classroom.group.program
          programs.push(program)
      }
    })

    sortBy(programs, 'name')

    commit('SET_PROGRAMS', programs)
  }
}
```
:::

### `@/vuex/modules/sponsor`

#### State

::: details state
```js
export const state = {
  classrooms: [],
}
```
:::

#### Getters

::: details getters
```js
export const getters = {}
```
:::

#### Actions

::: details actions
```js
export const actions = {}
```
:::


### `@/vuex/modules/user`

#### State

::: details state
```js
export const state = {
  classrooms: [],
}
```
:::

#### Getters

::: details getters
```js
export const getters = {
  getUser: state => state.user,

  getUserType: (state) => {
    const requireFullInfo = ['parent', 'teacher']
    let isValidUser = true
    if (requireFullInfo.includes(state.userType)) {
      if (!validateUserHasFullInfo(state.user)) {
        isValidUser = false
      }
    }
    if (isValidUser) {
      return state.userType
    }
    return 'incompleteProfile'
  },
  getAvatarPath: state => `https://${state.s3Bucket}.s3.amazonaws.com/${state.avatarPath}`
}
```

:::

#### Actions

::: details actions
```js
export const actions = {
  setUser: ({ state, commit, getters, dispatch }, user) => {
    const mutatedUser = mutateUser(user)

    if (typeof (mutatedUser.notifications) !== 'undefined') {
      dispatch('setNotifications', mutatedUser.notifications)
    }
    commit('SET_USER', mutatedUser)
  },
  setUserPhoto: ({ state, commit, getters, dispatch }, photo) => {
    commit('SET_NEW_USER_PHOTO', photo)
  },
  setUserPhotoFile: ({ state, commit, getters, dispatch }, blob) => {
    commit('SET_NEW_USER_PHOTO_FILE', blob)
  },
  setAvatarPath ({ state }, avatarPath) {
    state.avatarPath = avatarPath
  },
  updateUser ({ state, commit }, properties) {
    let user = {...state.user.user, ...properties}
    commit('UPDATE_USER', user)
  },
  refreshUser: ({ state, commit, getters, dispatch }) => {
    this.$axios.get('/v3/home/dashboard-user').then(response => {
      dispatch('setUser', response.data)
    })
  },

  redirectToPayPledges () {
    GoogleAnalytics.methods.gaEvent('Parent Dashboard', 'Pledges', 'Pay Pledges')
    window.location.href = '/v3/tkdashboard?redirect=home/payment'
  }
}
```
:::
