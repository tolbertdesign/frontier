<?php

namespace App;

use App\Entities\User;
use Illuminate\support\Collection;

class FamilyPledging
{
    /**
     * participants function
     *
     * @param User $participantUser
     * @return Collection
     */
    public function participants(User $participantUser)
    {
        $program = $participantUser->participantInfo->classroom->group->program;

        $isFamilyPledingEnabled = $program->getProgramPledgeSetting()->family_pledging_enabled &&
            $participantUser->participantInfo->family_pledging_enabled;
        if ($isFamilyPledingEnabled) {
            $participants = $participantUser
                ->parents->first()
                ->participants
                ->sortBy('id')
                ->filter(
                    function ($participantUser) use ($program) {
                        $isInProgram = $participantUser->participantInfo->classroom->group->program_id === $program->id;
                        $isNotTeacher = ! $participantUser->hasRole('teachers');
                        return $isInProgram && $isNotTeacher;
                    }
                );
        } else {
            $participants = collect([$participantUser]);
        }
        return $participants;
    }

    /**
     * @param Collection $users
     * @return String
     */
    public static function displayNames(Collection $users)
    {
        if ($users->count() == 1) {
            return $users->first()->first_name;
        }
        if ($users->count() == 2) {
            return $users->first()->first_name . ' and ' . $users->last()->first_name;
        }
        $names = $users->map(function ($user) {
            return $user->first_name;
        });
        $last = $names->pop();
        return $names->implode(', ') . ' and ' . $last;
    }

    /**
     * @param Collection $users
     *
     * @param Collection $users
     * @return String
     */
    public static function shareImage(Collection $users)
    {
        //return a user profile image
        foreach ($users as $user) {
            $profileImage = $user->profile->imageUrl();
            if ($profileImage) {
                return $profileImage;
            }
        }

        //if no user image return school logo
        return $user->getProgram()->microsite->schoolImageUrl();
    }
}
