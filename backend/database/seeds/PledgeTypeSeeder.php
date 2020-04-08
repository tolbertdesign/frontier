<?php

use Illuminate\Database\Seeder;
use App\Entities\PledgeType;

class PledgeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PledgeType::insert([
        ['name'              => 'PPL',
        'long_name'          => 'Pledge Per Lap',
        'multiplier_low'     => '30',
        'multiplier_high'    => '35',
        'multiplier_average' => '30'],

        ['name'              => 'PPJ',
        'long_name'          => 'Pledge Per Jump',
        'multiplier_low'     => '50',
        'multiplier_high'    => '100',
        'multiplier_average' => '75'],

        ['name'              => 'Flat',
        'long_name'          => 'Flat Donation',
        'multiplier_low'     => '1',
        'multiplier_high'    => '1',
        'multiplier_average' => '1']
        ]);
    }
}
