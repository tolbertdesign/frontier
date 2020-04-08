<?php

use Illuminate\Database\Seeder;
use App\Entities\Grade;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grade::insert(
            [
                [
                'id'   => -2,
                'name' => 'Other',
                ],
                [
                'id'   => -1,
                'name' => 'Pre-K',
                ],
                [
                'id'   => 0,
                'name' => 'Kindergarten',
                ],
                [
                'id'   => 1,
                'name' => '1st',
                ],
                [
                'id'   => 2,
                'name' => '2nd',
                ],
                [
                'id'   => 3,
                'name' => '3rd',
                ],
                [
                'id'   => 4,
                'name' => '4th',
                ],
                [
                'id'   => 5,
                'name' => '5th',
                ],
                [
                'id'   => 6,
                'name' => '6th',
                ],
                [
                'id'   => 7,
                'name' => '7th',
                ],
                [
                'id'   => 8,
                'name' => '8th',
                ],
                [
                'id'   => 9,
                'name' => '9th',
                ],
                [
                'id'   => 10,
                'name' => '10th',
                ],
                [
                'id'   => 11,
                'name' => '11th',
                ],
                [
                'id'   => 12,
                'name' => '12th',
                ]
            ]
        );

        Grade::where('id', '>', 0)->update(
            ['display_name' => DB::raw('CONCAT(name, " Grade")')]
        );

        Grade::whereIn('id', [0, -1])->update(
            ['display_name' => DB::raw('CONCAT(name)')]
        );
    }
}
