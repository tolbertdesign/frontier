<?php

use Illuminate\Database\Seeder;
use App\Entities\User;
use App\Models\RegisterModel;
use App\Entities\Classroom;

class TeacherSeeder extends Seeder
{
    const MAIN_CLASSROOM_ID = 126106;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classroom = Classroom::find(self::MAIN_CLASSROOM_ID);
        $user      = factory(User::class)->create([
            'first_name'    => 'teacher',
            'last_name'     => 'teacher',
            'email'         => 'teacher@example.com',
            'username'      => 'teacher@example.com',
        ]);

        $registerModel = new RegisterModel();
        $teacher       = $registerModel->registerTeacher($user, $classroom->team_leader_code);
        $teacher->parents()->save($user);
    }
}
