<?php

namespace App\Models\DashboardUser;

use App\Entities\User as UserEntity;
use App\Facades\FeatureFlag;

abstract class User
{
    public function __construct(UserEntity $user)
    {
        $this->user = $user;
    }

    protected function getRelationships()
    {
        return [
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
        ];
    }

    public function get()
    {
        $this->user->append('group_membership')->append('is_teacher_user');

        if (FeatureFlag::checkIfGloballyEnabled('notifications')) {
            $this->user->append('notifications');
        }

        $relationships = $this->getRelationships();
        $this->user->load(...$relationships);

        return $this->user;
    }
}
