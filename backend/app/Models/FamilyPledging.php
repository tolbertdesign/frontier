<?php
namespace App\Models;

use App\Entities\Participant;
use App\Entities\Role;
use App\Entities\User;
use Exception;
use Illuminate\support\Collection;
use Illuminate\Support\Facades\Auth;

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
        $isFamilyPledgingEnabled = $program->getProgramPledgeSetting()->family_pledging_enabled &&
            $participantUser->participantInfo->family_pledging_enabled;
        if ($isFamilyPledgingEnabled) {
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

    /**
     * @param Collection $users
     * @return String
     */
    public function hasVideo(Collection $users)
    {
        //return a user profile image
        foreach ($users as $user) {
            if ($user->profile && $user->profile->video_url) {
                return true;
            }
        }
        return false;
    }

    /**
     * sets family pledging for all participants in the program
     * verifies that you are the parent of the participants
     * verifies that you are not setting it to null
     *
     * @param User $participantUser
     * @param Bool $enable
     * @return void
     */
    public function setFamilyPledging(User $participantUser, Bool $enable)
    {
        $isMyParticipant = $participantUser->parents->contains(Auth::user());
        if ($enable === null || !$isMyParticipant) {
            return;
        }

        $participantIds = Participant::select(['participants.id'])
            ->join('students_parents', 'students_parents.student_id', '=', 'participants.user_id')
            ->join('classrooms', 'classrooms.id', '=', 'participants.classroom_id')
            ->join('groups', 'groups.id', '=', 'classrooms.group_id')
            ->leftJoin('model_has_roles', function ($join) {
                $join->on('model_has_roles.model_id', '=', 'participants.user_id')
                    ->where('model_has_roles.role_id', Role::TEACHER_ROLE_ID); // 7 is the role id for teachers
            })
            ->where([
                ['students_parents.parent_id', '=', $participantUser->parents->first()->id],
                ['groups.program_id', '=', $participantUser->getProgram()->id],
            ])->whereNull('model_has_roles.role_id')->pluck('id')->toArray();

        Participant::whereIn('id', $participantIds)
            ->update(['family_pledging_enabled' => $enable]);
    }
}
