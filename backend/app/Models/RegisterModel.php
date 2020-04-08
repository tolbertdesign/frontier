<?php

namespace App\Models;

use App\Libraries\FrCodeGenerator;
use App\Entities\User;
use App\Entities\Classroom;
use App\Entities\UserProfile;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Support\Facades\Lang;
use App\Entities\UserTask;
use App\Jobs\AddUserNotifications;
use App\Jobs\BindParticipantPrizes;
use App\Models\FamilyPledging;
use App\Libraries\CacheKeys;
use App\Models\UploadImageModel;
use App\Models\StudentStarModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Facades\FeatureFlag;

class RegisterModel
{
    private $imageName = null;

    public function registerParent($data)
    {
        $data['dob'] = null;
        if ($data['year'] && $data['month'] && $data['day']) {
            $data['dob'] = Carbon::createFromDate($data['year'], $data['month'], $data['day']);
        }
        $parentUser  = User::create(
            [
                'first_name'          => $data['first_name'],
                'last_name'           => $data['last_name'],
                'email'               => $data['email'],
                'username'            => $data['email'],
                'password'            => bcrypt($data['password']),
                'created_on'          => time(),
                'active'              => 1,
                'phone'               => $data['phone'],
                'dob'                 => $data['dob'],
                'fr_code'             => FrCodeGenerator::generate(),
                'marketing_opt_in_ts' => !empty($data['marketing_opt_in']) ? Carbon::now() : null,
            ]
        );
        $rolesForParent = ['members', 'parents'];
        $parentUser->assignRole($rolesForParent);
        return $parentUser;
    }

    public function registerTeacher($user, $teacherRegistrationCode)
    {
        $classroom   = Classroom::where('team_leader_code', $teacherRegistrationCode)->first();
        $teacherUser = User::create(
            [
                'first_name'    => $user->first_name,
                'last_name'     => $user->last_name,
                'username'      => '',
                'password'      => '',
                'created_on'    => time(),
                'active'        => 1,
                'fr_code'       => FrCodeGenerator::generate(),
                'waiver_ts'     => Carbon::now(),
                'waiver_dob'    => $user->dob,
                'waiver_signed' => 1
            ]
        );

        if (!$this->saveTeacherToClassroom($teacherUser, $classroom)) {
            return false;
        }

        $rolesForTeacher = ['members', 'teachers'];
        $teacherUser->assignRole($rolesForTeacher);
        $this->createParticipantDefaults($teacherUser, $classroom);
        $this->assignTeacherTasks($teacherUser);
        return $teacherUser;
    }

    public function assignTeacherTasks($teacherUser)
    {
        $programId = $teacherUser->classroom->first()->group->program->id;
        foreach (config('tasks.teacher_checklist') as $key => $taskTitle) {
            $teacherTaskData = [
                'program_id'          => $programId,
                'assigned_to_user_id' => $teacherUser->id,
                'type'                => 'Teacher',
                'title'               => $taskTitle,
                'created_by_user_id'  => $teacherUser->id,
            ];
            UserTask::create($teacherTaskData);
        }
        return true;
    }

    public function saveTeacherToClassroom($teacherUser, $classroom)
    {
        if (empty($classroom->teacher_id)) {
            $classroom->teacher_id = $teacherUser->id;
        } elseif (empty($classroom->teacher_2_id)) {
            $classroom->teacher_2_id = $teacherUser->id;
        } elseif (empty($classroom->teacher_3_id)) {
            $classroom->teacher_3_id = $teacherUser->id;
        } else {
            return false;
        }

        $classroom->save();
        return true;
    }

    public function createParticipantDefaults($participantUser, $classroom)
    {
        $program = $classroom->group->program;
        $participantUser->classroom()->save($classroom);
        $this->createParticipantProfile($participantUser, $classroom);
        $participantUser->createSpecialUrls();

        // if (FeatureFlag::checkIfGloballyEnabled('notifications')) {
        //     $this->addDashboardUserToCache($program->id);

        //     if (Auth::check()) {
        //         AddUserNotifications::dispatch(Auth::id(), $program->id);
        //     }
        // }

        $this->bindNewParticipantPrizes($participantUser);
        return $participantUser;
    }

    private function createParticipantProfile($participantUser, $classroom)
    {
        return UserProfile::create(
            [
                'user_id'      => $participantUser->id,
                'created'      => date('Y-m-d H:i:s'),
                'pledge_goal'  => $classroom->group->program->getProgramPledgeSetting()->getDefaultPledgeGoal(),
                'image_name'   => $this->imageName,
            ]
        );
    }

    public function addDashboardUserToCache(int $programId)
    {
        $cacheKey     = CacheKeys::getDashboardUserIdsByProgramId($programId);
        $currentCache = Cache::get($cacheKey);

        if (is_null($currentCache) || !is_array($currentCache)) {
            $currentCache = [];
        }

        array_push($currentCache, Auth::id());

        Cache::rememberForever($cacheKey, function () use ($currentCache) {
            return $currentCache;
        });
    }

    public function validateTeacherRegistrationCode($teacherRegistrationCode)
    {
        try {
            $classroom = Classroom::where('team_leader_code', $teacherRegistrationCode)->firstOrFail();

            $result = [
                'message' => '',
                'success' => true,
            ];

            $isMaxTeachersReached = $classroom->teacher_id && $classroom->teacher_2_id && $classroom->teacher_3_id;
            if ($isMaxTeachersReached) {
                $result = [
                    'message' => Lang::get('register.max_teachers_reached'),
                    'success' => false,
                ];
            }
        } catch (Exception $e) {
            $result = [
                'message' => Lang::get('register.invalid_teacher_code'),
                'success' => false,
            ];
        }
        return $result;
    }

    /**
     * Creates a new participant user
     * @param App\Entities\User Participant user
     * @param App\Entities\User Parents user of participant
     * @param App\Entities\Classroom Classroom of particpant
     * @param Boolean Family pledge status
     */
    public function createParticipant($user, $parent, $classroom, $familyPledgingEnabled, $imageFile)
    {
        $uploadImageModel = new UploadImageModel();
        $this->imageName  = $uploadImageModel->uploadParticipantImage($imageFile, $user->id);

        $this->createParticipantDefaults($user, $classroom);

        $program = $classroom->group->program;

        if ($this->imageName && !$program->ssv_disabled) {
            $imageUrl         = $user->makeUserProfileImageUrl($this->imageName);
            $studentStarModel = new StudentStarModel();
            $studentStarModel->createJob(
                $imageUrl,
                $user->id,
                $user->first_name,
                $user->getProgram()->event_name
            );
        }

        $user->parents()->save($parent);
        $rolesForStudent = ['members', 'students'];
        $user->assignRole($rolesForStudent);

        $familyPledging = new FamilyPledging();
        $familyPledging->setFamilyPledging($user, $familyPledgingEnabled);
    }

    /**
     * Determine if family pledging should be enabled for a parent's newest participant
     *
     * @param App\Entities\User     parentUser
     * @param App\Entities\Program  program
     * @return Boolean
     */
    public function setFamilyPledgingStatusForParticipant(User $parentUser, $program)
    {
        $familyPledgingEnabledForProgram = $program->getProgramPledgeSetting()->family_pledging_enabled;
        if (!$familyPledgingEnabledForProgram) {
            return false;
        }

        $participantUsers = $parentUser->participants;
        if ($participantUsers->count() === 0) {
            return false;
        }

        $participantUsersInProgram = $participantUsers->filter(function ($participantUser) use ($program) {
            if ($participantUser->hasRole('teachers')) {
                return false;
            }

            return $participantUser->getProgram()->id === $program->id;
        });

        if ($participantUsersInProgram->count() > 0) {
            return true;
        }

        return false;
    }

    protected function bindNewParticipantPrizes(User $participantUser)
    {
        $bindParticipantPrizeJob = new BindParticipantPrizes($participantUser);
        try {
            $this->bindNewParticipantPrizesNow($bindParticipantPrizeJob);
        } catch (Exception $e) {
            $this->bindNewParticipantPrizesAsync($bindParticipantPrizeJob);
        }
    }

    protected function bindNewParticipantPrizesNow($bindParticipantPrizeJob)
    {
        dispatch_now($bindParticipantPrizeJob);
    }

    protected function bindNewParticipantPrizesAsync($bindParticipantPrizeJob)
    {
        dispatch($bindParticipantPrizeJob);
    }
}
