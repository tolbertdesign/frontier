export const namespaced = true
const state = () => ({
  classrooms: [],
})

const getters = {
  classrooms: state => state.classrooms,

  classroomsByGrade: getters => {
    return getters.classrooms
      .filter(classroom => !classroom.deleted)
      .reduce((classrooms, classroom) => {
        const grade = (classroom.grade.id > 0) ? `${classroom.grade.name} Grade` : classroom.grade.name
        if (!classrooms[grade]) {
          classrooms[grade] = []
        }
        classrooms[grade].push(classroom)
        return classrooms
      }, {})
  },

  classroom: state => id => {
    return state.classrooms.find(classroom => classroom.id === id)
  },

}

const mutations = {
  SET_CLASSROOMS: (state, classrooms) => {
    state.classrooms = classrooms
  },
}

const actions = {
  initClassrooms: ({ commit, rootGetters }) => {
    const currentClassrooms = []

    rootGetters['program/programs'].forEach(program => {
      program.classrooms.forEach(programClassroom => {
        const classroomCheck = currentClassrooms.find(classroom => classroom.id === programClassroom.id)
        if (classroomCheck === undefined) {
          currentClassrooms.push(programClassroom)
        }
      })
    })

    commit('SET_CLASSROOMS', currentClassrooms)
  },
}

export default {
  namespaced,
  state,
  getters,
  mutations,
  actions,
}
