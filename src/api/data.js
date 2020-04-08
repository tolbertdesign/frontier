import faker from 'faker'

const seedUsers = function (quantity, data) {
  for (let i = 1; i <= quantity; i++) {
    const gender = faker.random.number({ min: 1, max: 2 })
    const firstName = faker.name.firstName(gender)
    const lastName = faker.name.lastName(gender)

    data.users.push({
      id: i,
      name: faker.name.findName(firstName, lastName, gender),
      username: faker.internet.userName(firstName, lastName),
      email: faker.internet.email(firstName, lastName).toLowerCase(),
      gender: gender,
      dateOfBirth: faker.date.past(55, new Date()),
      ocuppation: faker.name.jobTitle(),
      avatar: faker.internet.avatar(),
    })
  }
}

const seedCategories = function (quantity, data) {
  // eslint-disable-next-line
  String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1)
  }

  for (let i = 1; i <= quantity; i++) {
    data.categories.push({
      id: i,
      name: faker.lorem.words(faker.random.number({ min: 1, max: 2 })).capitalize(),
    })
  }
}

const seedPosts = function (quantity, data) {
  for (let i = 1; i <= quantity; i++) {
    const title = faker.lorem.sentence()

    data.posts.push({
      id: i,
      title: title,
      body: faker.lorem.paragraphs(faker.random.number({ min: 2, max: 12 })),
      image: faker.image.image(),
      views: faker.random.number(1500),
      recommends: faker.random.number(50),
      userId: faker.random.number({ min: 1, max: data.users.length }),
      categoryId: faker.random.number({ min: 1, max: data.categories.length }),
    })
  }
}

const seedComments = function (quantity, data) {
  for (let i = 1; i <= quantity; i++) {
    data.comments.push({
      id: i,
      body: faker.lorem.sentences(faker.random.number({ min: 1, max: 5 })),
      userId: faker.random.number({ min: 1, max: data.users.length }),
      postId: faker.random.number({ min: 1, max: data.posts.length }),
    })
  }
}

const seedProfile = function (data) {
  data.profile = faker.random.arrayElement(data.users)
}

const db = function () {
  const data = {
    users: [],
    categories: [],
    posts: [],
    comments: [],
    profile: {},
  }

  seedUsers(100, data)
  seedCategories(30, data)
  seedPosts(150, data)
  seedComments(300, data)
  seedProfile(data)

  return data
}

export default db
