function mutateUser (user) {
  const participants = user.participants
  delete user.participants
  const programs = []
  participants.forEach(participant => {
    const programId = participant.participant_info.classroom.group.program.id
    participant.participant_info.pledges.forEach(pledge => {
      pledge.amount = parseFloat(pledge.amount)
    })
    const family_pledging_enabled = participant.participant_info.family_pledging_enabled &&
            participant.participant_info.classroom.group.program.program_pledge_setting.family_pledging_enabled
    let program = programs.find(program => program.id === programId)
    if (program === undefined || !family_pledging_enabled) {
      program = participant.participant_info.classroom.group.program
      program.participants = []
      programs.push(program)
    }
    program.participants.push(participant)
  })

  // Sort Alphabetically
  programs.forEach(program => {
    program.participants.sort((a, b) => ('' + a.first_name).localeCompare(b.first_name))
  })
  programs.sort((a, b) => ('' + a.name).localeCompare(b.name))

  user.programs = programs

  return user
}

export default mutateUser
