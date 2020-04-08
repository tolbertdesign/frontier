<?php

use Illuminate\Database\Seeder;
use App\Entities\EnteredLocation;

class EnteredLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EnteredLocation::insert([
            ['name' => 'Participant Dashboard'],
            ['name' => 'Public Pledge'],
            ['name' => 'Admin'],
        ]);
    }
}
