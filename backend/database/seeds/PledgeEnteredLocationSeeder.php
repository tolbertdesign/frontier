<?php

use Illuminate\Database\Seeder;
use App\Entities\EnteredLocation;
use App\Entities\Pledge;

class PledgeEnteredLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pledges          = Pledge::all();
        $enteredLocations = EnteredLocation::all();

        $pledges->each(function ($pledge) use ($enteredLocations) {
            $enteredLocation = $enteredLocations->random();
            if ($enteredLocation->name !== 'Public Pledge') {
                $pledge->referrers()->detach();
            }
            $pledge->enteredLocations()->save($enteredLocation);
        });
    }
}
