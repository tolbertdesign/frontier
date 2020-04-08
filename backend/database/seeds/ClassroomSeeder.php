<?php

use Illuminate\Database\Seeder;
use App\Entities\Classroom;
use App\Entities\Group;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classroom = new Classroom([
            'id'                     => 126106,
            'grade_id'               => -2,
            'name'                   => 'QAClass',
            'group_id'               => 9205,
            'teacher_id'             => null,
            'teacher_2_id'           => null,
            'teacher_3_id'           => null,
            'last_updated'           => '2016-07-12 15:00:20',
            'number_of_participants' => 30,
            'team_member_code'       => 82010296,
            'team_leader_code'       => 39018685,
            'pledge_meter'           => '10.00',
            'deleted'                => 0,
        ]);
        $classroom->save();

        $groups = Group::all();
        foreach ($groups as $group) {
            factory(Classroom::class, rand(7, 10))->create(
                [
                        'group_id' => $group->id
                ]
            );
        }
    }
}
