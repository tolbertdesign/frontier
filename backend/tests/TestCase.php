<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Entities\Classroom;
use App\Entities\Pledge;
use App\Entities\OnlinePendingPayment;
use App\Entities\User;
use App\Entities\UsersUserGroup;
use App\Models\RegisterModel;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Creates a user that has a teacher participant attached to a classroom
     *
     * @return App\Entities\User Teacher
     */
    public function createTeacherUser()
    {
        $user = factory(User::class)->create();
        $classroom = Classroom::first();
        $classroom->teacher_id = null;
        $classroom->save();
        $register = new RegisterModel();
        $teacherParticipant = $register->registerTeacher($user, $classroom->team_leader_code);
        $teacherParticipant->parents()->save($user);
        return $user;
    }

    public function createSponsorUser()
    {
        $user   = factory(User::class)->create();
        $pledge = factory(Pledge::class)->create([
            'user_id'=>$user->id,
            'pledge_status_id' => Pledge::PENDING_STATUS
        ]);
        $onlinePendingPayment = factory(OnlinePendingPayment::class)->create([
            'deleted'=> 0,
            'bt_customer_id' => 1,
            'bt_token_id' => 1
        ]);
        $pledge->onlinePendingPayments()->save($onlinePendingPayment);
        $pledge->save();

        return $user;

    }

    public function createOrgAdminUser()
    {
        $user = factory(User::class)->create();
        $usersUserGroup = new UsersUserGroup();
        $usersUserGroup->user_id = $user->id;
        $usersUserGroup->group_id = User::ORG_ADMIN_USERS_GROUP_ID;
        $usersUserGroup->save();
        return $user;
    }

    public function createSuperAdminUser()
    {
        $user = factory(User::class)->create();
        $usersUserGroup = new UsersUserGroup();
        $usersUserGroup->user_id = $user->id;
        $usersUserGroup->group_id = User::SUPER_ADMIN_USERS_GROUP_ID;
        $usersUserGroup->save();
        return $user;
    }

    public function createAdminUser()
    {
        $user = factory(User::class)->create();
        $usersUserGroup = new UsersUserGroup();
        $usersUserGroup->user_id = $user->id;
        $usersUserGroup->group_id = User::ADMIN_USERS_GROUP_ID;
        $usersUserGroup->save();
        return $user;
    }

    public function createVolunteerUser()
    {
        $user = factory(User::class)->create();
        $usersUserGroup = new UsersUserGroup();
        $usersUserGroup->user_id = $user->id;
        $usersUserGroup->group_id = User::VOLUNTEER_USERS_GROUP_ID;
        $usersUserGroup->save();
        return $user;
    }
}
