<?php

use Illuminate\Database\Seeder;
use App\Entities\PledgePeriod;
use App\Entities\Program;

class PledgePeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programs = Program::where('id', '!=', 2)->get();

        $programs->each(function ($program) {
            PledgePeriod::insert(
                [
                    [
                        'delivery_ts' => '2016-08-02 08:00:00',
                        'ordinal'     => 1,
                        'program_id'  => $program->id,
                    ],
                    [
                        'delivery_ts' => '2016-08-03 08:00:00',
                        'ordinal'     => 2,
                        'program_id'  => $program->id,
                    ],
                    [
                        'delivery_ts' => '2016-08-04 08:00:00',
                        'ordinal'     => 3,
                        'program_id'  => $program->id,
                    ],
                    [
                        'delivery_ts' => '2016-08-05 08:00:00',
                        'ordinal'     => 4,
                        'program_id'  => $program->id,
                    ],
                    [
                        'delivery_ts' => '2016-08-08 08:00:00',
                        'ordinal'     => 5,
                        'program_id'  => $program->id,
                    ],
                    [
                        'delivery_ts' => '2017-01-06 08:00:00',
                        'ordinal'     => 6,
                        'program_id'  => $program->id,
                    ],
                    [
                        'delivery_ts' => '2017-01-09 08:00:00',
                        'ordinal'     => 7,
                        'program_id'  => $program->id,
                    ],
                    [
                        'delivery_ts' => '2017-01-10 08:00:00',
                        'ordinal'     => 8,
                        'program_id'  => $program->id,
                    ],
                    [
                        'delivery_ts' => '2020-11-30 08:00:00',
                        'ordinal'     => 9,
                        'program_id'  => $program->id,
                    ]
                ]
            );
        });
    }
}
