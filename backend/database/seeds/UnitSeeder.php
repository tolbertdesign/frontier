<?php

use Illuminate\Database\Seeder;
use App\Entities\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::insert([
            [
                'id'                  => 1,
                'title'               => 'Laps',
                'name'                => 'lap',
                'name_plural'         => 'laps',
                'modifier'            => 'per',
                'multiplier_internal' => 32,
                'default_multiplier'  => 30,
                'default_lower_limit' => 30,
                'default_upper_limit' => 35,
                'created_at'          => '2016-05-17 15:15:52',
                'updated_at'          => '2016-05-17 15:15:52',
                'deleted_at'          => null,
            ], [
                'id'                  => 2,
                'title'               => 'Reading',
                'name'                => 'reading challenge',
                'name_plural'         => 'reading challenges',
                'modifier'            => 'per',
                'multiplier_internal' => 32,
                'default_multiplier'  => 30,
                'default_lower_limit' => 30,
                'default_upper_limit' => 35,
                'created_at'          => '2016-05-17 15:15:52',
                'updated_at'          => '2016-05-17 15:15:52',
                'deleted_at'          => null,
            ], [
                'id'                  => 4,
                'title'               => 'Golden Rule',
                'name'                => 'act of service',
                'name_plural'         => 'acts of service',
                'modifier'            => 'per',
                'multiplier_internal' => 33,
                'default_multiplier'  => 30,
                'default_lower_limit' => 30,
                'default_upper_limit' => 35,
                'created_at'          => '2016-08-22 08:49:00',
                'updated_at'          => '2016-08-22 08:49:00',
                'deleted_at'          => null,
            ]
        ]);
    }
}
