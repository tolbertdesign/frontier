import store from './index'

describe('store', () => {
  window.gtag = jest.fn()
  const user = {
    participants: [],
  }
  beforeEach(() => {
    user.participants = []
  })

  it('splits programs with participants with family pledging disabled', () => {
    addParticipant(1, 1, 0)
    addParticipant(1, 1, 0)
    store.dispatch('setUser', user)
    expect(store.state.User.programs.length).toBe(2)
  })

  it('splits programs with family pledging disabled', () => {
    addParticipant(1, 0, 1)
    addParticipant(1, 0, 1)
    store.dispatch('setUser', user)

    expect(store.state.User.programs.length).toBe(2)
  })

  it('splits programs with family pledging disabled and participants with family pledging disabled', () => {
    addParticipant(1, 0, 0)
    addParticipant(1, 0, 0)
    store.dispatch('setUser', user)

    expect(store.state.User.programs.length).toBe(2)
  })

  it('combines programs with family pledging enabled', () => {
    addParticipant(1, 1, 1)
    addParticipant(1, 1, 1)
    store.dispatch('setUser', user)

    expect(store.state.User.programs.length).toBe(1)
  })

  const addParticipant = (programId, programFamilyPledging, participantFamilyPledging) => {
    user.participants.push(
      {
        participant_info: {
          classroom: {
            group: {
              program: {
                id: programId,
                program_pledge_setting: {
                  family_pledging_enabled: programFamilyPledging,
                },
              },
            },
          },
          family_pledging_enabled: participantFamilyPledging,
          pledges: [],
        },
      })
  }
})
