import $store from './index.js'

const programId = 1
const notification1 = {
  id: 1,
  type: 'ProgramAlert',
  notifiable_type: 'App\\Entities\\User',
  notifiable_id: 5,
  program_id: programId,
  data: {
    content: 'content',
  },
  read_at: '2010/01/01 00:00:00',
  start_at: '2000/01/01 00:00:00',
  end_at: '2050/01/01 00:00:00',
}
const notification2 = {
  id: 2,
  type: 'ProgramAlert',
  notifiable_type: 'App\\Entities\\User',
  notifiable_id: 5,
  program_id: programId,
  data: {
    content: 'content',
  },
  read_at: null,
  start_at: '2000/01/01 00:00:00',
  end_at: '2050/01/01 00:00:00',
}
const notification3 = {
  id: 3,
  type: 'ProgramAlert',
  notifiable_type: 'App\\Entities\\User',
  notifiable_id: 5,
  program_id: 2,
  data: {
    content: 'content',
  },
  read_at: null,
  start_at: '2000/01/01 00:00:00',
  end_at: '2050/01/01 00:00:00',
}

const state = {
  notifications: [
    notification1,
    notification2,
    notification3,
  ],
}
const getters = {
  TYPES: jest.fn(),
  programNotifications: jest.fn(),
  unReadNotifications: jest.fn(),
  isRead: jest.fn(),
  programHasNotifications: jest.fn(),
}

describe('getters', () => {
  it('returns correct program notifications', () => {
    const programNotifications = $store.getters.programNotifications(state)(programId)
    expect(programNotifications).toStrictEqual([notification1, notification2])
  })
  it('returns correct notifications outside of the program', () => {
    const notificationsOutsideOfProgram = $store.getters.notificationsOutsideOfProgram(state)(programId)
    expect(notificationsOutsideOfProgram).toStrictEqual([notification3])
  })

  it('correctly gets isRead notifications', () => {
    getters.isRead = jest.fn(() => false)
    const unReadNotifications = $store.getters.unReadNotifications(state, getters)
    expect(unReadNotifications).toStrictEqual(state.notifications)
    getters.isRead = jest.fn()
  })

  it('correctly filters out isRead notifications', () => {
    getters.isRead = jest.fn(() => true)
    const unReadNotifications = $store.getters.unReadNotifications(state, getters)
    expect(unReadNotifications).toStrictEqual([])
    getters.isRead = jest.fn()
  })

  it('correctly checks that read notification isRead', () => {
    const isRead = $store.getters.isRead(state)(notification1)
    expect(isRead).toBeTruthy()
  })

  it('correctly checks that unread notification isRead', () => {
    const isRead = $store.getters.isRead(state)(notification2)
    expect(isRead).not.toBeTruthy()
  })

  it('checks that programNotifications called and checks length using mocked empty array return', () => {
    getters.programNotifications = jest.fn(() => [])
    const programHasNotifications = $store.getters.programHasNotifications(state, getters)(programId)
    expect(programHasNotifications).not.toBeTruthy()
  })

  it('checks that programNotifications called and checks length using mocked array return', () => {
    getters.programNotifications = jest.fn(() => [1, 2, 3])
    const programHasNotifications = $store.getters.programHasNotifications(state, getters)(programId)
    expect(programHasNotifications).toBeTruthy()
  })
})
