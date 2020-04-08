<?php

use Illuminate\Database\Seeder;
use App\Entities\Group;
use App\Entities\Program;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::insert(
            [
                [
                'id'                           => 9205,
                'salesforce_id'                => 'a4NU0000000CcQBMA0',
                'name'                         => 'Primary1',
                'classroom_goal'               => null,
                'projected_students'           => null,
                'program_id'                   => 1,
                'point_person_id'              => null,
                'projected_raised_per_student' => null,
                'projected_raised'             => null,
                'preprogram_students'          => null,
                'participating_students'       => null,
                'preprogram_homerooms'         => null,
                'preprogram_faculty'           => null,
                'lap_average'                  => null,
                'actual_students'              => null,
                'actual_students_override'     => 0,
                'level'                        => 'Primary',
                'pep_rally'                    => null,
                'fun_run'                      => null,
                'due_date'                     => null,
                'populated'                    => null,
                'group_level_id'               => null,
                'sf_program_id'                => 'a4MU0000001JCN3MAO',
                'sf_point_person_id'           => null,
                'sf_opportunity_id'            => '',
                'deleted'                      => 0,
                ],
                [
                'id'                           => 9215,
                'salesforce_id'                => 'a4NU0000000AYKlMAO',
                'name'                         => 'Primary2',
                'classroom_goal'               => null,
                'projected_students'           => null,
                'program_id'                   => 1,
                'point_person_id'              => null,
                'projected_raised_per_student' => null,
                'projected_raised'             => null,
                'preprogram_students'          => null,
                'participating_students'       => null,
                'preprogram_homerooms'         => null,
                'preprogram_faculty'           => null,
                'lap_average'                  => null,
                'actual_students'              => null,
                'actual_students_override'     => 0,
                'level'                        => 'Primary',
                'pep_rally'                    => null,
                'fun_run'                      => null,
                'due_date'                     => null,
                'populated'                    => null,
                'group_level_id'               => null,
                'sf_program_id'                => 'a4MU0000001JCN3MAO',
                'sf_point_person_id'           => null,
                'sf_opportunity_id'            => '',
                'deleted'                      => 0,
                ],
                [
                'id'                           => 9775,
                'salesforce_id'                => 'a4N0P0000004owfUAA',
                'name'                         => 'Primary3',
                'classroom_goal'               => null,
                'projected_students'           => null,
                'program_id'                   => 1,
                'point_person_id'              => null,
                'projected_raised_per_student' => null,
                'projected_raised'             => null,
                'preprogram_students'          => null,
                'participating_students'       => null,
                'preprogram_homerooms'         => null,
                'preprogram_faculty'           => null,
                'lap_average'                  => null,
                'actual_students'              => null,
                'actual_students_override'     => 0,
                'level'                        => 'Primary',
                'pep_rally'                    => null,
                'fun_run'                      => null,
                'due_date'                     => null,
                'populated'                    => null,
                'group_level_id'               => null,
                'sf_program_id'                => 'a4MU0000001JCN3MAO',
                'sf_point_person_id'           => null,
                'sf_opportunity_id'            => '',
                'deleted'                      => 0,
                ]
            ]
        );

        $programs = Program::where('id', '!=', 1)->get();
        foreach ($programs as $program) {
            factory(Group::class, rand(1, 2))->make(
                [
                    'program_id' => $program->id
                ]
            )->each(function ($program) {
                $program->save();
            });
        }
    }
}
