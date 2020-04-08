test('expectation', () => {
  expect('Some String').toBe('Some String')
  expect(7).toBe(7)
  expect([7]).toEqual([7])

  const result = {
    value: Date.now(),
  }

  expect(result).toEqual({
    value: expect.any(Number),
  })
})
