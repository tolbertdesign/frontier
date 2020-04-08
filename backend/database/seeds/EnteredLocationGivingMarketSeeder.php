<?php

use Illuminate\Database\Seeder;
use App\Entities\EnteredLocation;

class EnteredLocationGivingMarketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EnteredLocation::insert([
            ['name' => 'Giving Market Dashboard'],
        ]);
    }
}
