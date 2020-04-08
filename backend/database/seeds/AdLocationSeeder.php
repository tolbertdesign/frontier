<?php

use Illuminate\Database\Seeder;
use App\Entities\AdLocation;
use App\Entities\ProgramSponsorAd;

class AdLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create locations
        AdLocation::insert([
            [
               'location' => 'homepage_bottom',
            ], [
               'location' => 'register_participant_welcome_email',
            ], [
               'location' => 'parent_pledge_confirmation_email',
            ], [
               'location' => 'sponsor_pledge_confirmation_email',
            ], [
               'location' => 'payment_request_email',
            ], [
               'location' => 'payment_receipt_email',
            ], [
               'location' => 'homepage_bottom_mobile',
            ], [
               'location' => 'student_dashboard_mobile',
            ]
        ]);

        //attach locations to ads
        $ad       = ProgramSponsorAd::find(1);
        $location = AdLocation::find(1);
        $ad->adLocations()->save($location);

        $ad       = ProgramSponsorAd::find(2);
        $location = AdLocation::find(2);
        $ad->adLocations()->save($location);

        $location = AdLocation::find(3);
        $ad->adLocations()->save($location);

        $location = AdLocation::find(4);
        $ad->adLocations()->save($location);

        $location = AdLocation::find(5);
        $ad->adLocations()->save($location);

        $location = AdLocation::find(6);
        $ad->adLocations()->save($location);

        $ad       = ProgramSponsorAd::find(3);
        $location = AdLocation::find(8);
        $ad->adLocations()->save($location);
    }
}
