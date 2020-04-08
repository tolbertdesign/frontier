const user = {
  name: 'Victor Tolbert',
  age: 52,
  job: 'Software Engineer',
}

test('user matches', () => {
  const userString = '{"name":"Victor Tolbert","age":52,"job":"Software Engineer"}'
  expect(JSON.stringify(user)).toBe(userString)
  expect(user).toMatchSnapshot()
})
