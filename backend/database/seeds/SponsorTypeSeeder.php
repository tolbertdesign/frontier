<?php

use Illuminate\Database\Seeder;
use App\Entities\SponsorType;

class SponsorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sponsortype::insert([
            [
                'id'           => 1,
                'sponsor_type' => 'Parent',
                'description'  => null,
            ], [
                'id'           => 2,
                'sponsor_type' => 'Grandparent',
                'description'  => null,
            ], [
                'id'           => 3,
                'sponsor_type' => 'Relative',
                'description'  => null,
            ], [
                'id'           => 5,
                'sponsor_type' => 'Family Friend',
                'description'  => null,
            ], [
                'id'           => 6,
                'sponsor_type' => 'Co-Worker',
                'description'  => null,
            ], [
                'id'           => 7,
                'sponsor_type' => 'Business',
                'description'  => null,
            ], [
                'id'           => 8,
                'sponsor_type' => 'Corporate Matching Gift',
                'description'  => '',
            ], [
                'id'           => 99,
                'sponsor_type' => 'Other',
                'description'  => 'All other types not listed.  The name will be listed.  The' .
                    ' text will be stored under the specific pledge under the pledges table',
            ]
        ]);
    }
}
