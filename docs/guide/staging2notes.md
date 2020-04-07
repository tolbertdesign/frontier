- Get User

/var/www2/html/titan-dashboard
ssh -i ~/.ssh/boosterawsstaging2.pem ubuntu@10.2.1.37

$user = User::where('email', 'antcliffbooster+teacher@gmail.com')->first();
$user->load(
  'participants',
  'participants.profile',
  'participants.prizes',
  'participants.participantInfo',
  'participants.participantInfo.pledges',
  'participants.participantInfo.pledges.pledgeSponsor',
  'participants.participantInfo.pledges.pledgeSponsor.countryEntity',
  'participants.participantInfo.pledges.pledgeSponsor.emailOptOut',
  'participants.participantInfo.pledges.pledgeSponsor.user',
  'participants.participantInfo.potentialSponsors',
  'participants.participantInfo.potentialSponsors.emailOptOut',
  'participants.participantInfo.prizeBoundStudents',
  'participants.participantInfo.classroom.grade',
  'participants.participantInfo.classroom.group.prizesBound',
  'participants.participantInfo.classroom.group.program',
  'participants.participantInfo.classroom.group.program.classrooms',
  'participants.participantInfo.classroom.group.program.classrooms.grade',
  'participants.participantInfo.classroom.group.program.microsite',
  'participants.participantInfo.classroom.group.program.microsite.micrositeColorTheme',
  'participants.participantInfo.classroom.group.program.unit',
  'participants.participantInfo.classroom.group.program.programPledgeSetting',
  'participants.specialUrls',
  'participants.specialUrls.referrer'
);
$user->toJson()
$user->append('group_membership')
user->toJson()
