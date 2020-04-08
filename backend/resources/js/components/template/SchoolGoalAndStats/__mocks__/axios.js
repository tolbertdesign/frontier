export default {
  get: jest.fn(() => Promise.resolve({ data: 5 })),
  all: jest.fn(() => Promise.resolve({ data: true })),
}
