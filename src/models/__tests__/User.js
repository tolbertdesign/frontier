import User from '@/models/User'

describe('User.js', () => {
  test('name returns first name', () => {
    const user = new User({
      firstName: 'Victor',
      lastName: 'Tolbert',
    })

    expect(user.name).toBe('Victor Tolbert')
  })
})
