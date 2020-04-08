<?php

use Illuminate\Database\Seeder;
use App\Entities\School;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $school = new School([
            // 'id'                  => 1,
            'name'                => 'Salesforce Test',
            'type'                => 'Client',
            'address'             => '1234 address changed',
            'city'                => 'Atlanta',
            'state'               => 'ga',
            'zip'                 => 20035,
            'country'             => null,
            'charter'             => '2-No',
            'school_wide_title_1' => '2-No',
            'urban_locale'        => null,
            'county'              => 'DeKalb',
            'latitude'            => '38.90',
            'longitude'           => '-77.04',
            'category'            => null,
            'level'               => null,
            'metro_area'          => null,
            'deleted'             => 0,
            'sf_updated_date'     => '2016-10-31 14:42:41',
            'sf_created_date'     => '2012-02-29 21:31:08',
            'salesforce_id'       => '001U000000BjAF7IAN',
            'timezone'            => 'America/New_York',
            'merchant_type'       => 'braintree',
        ]);
        $school->save();
    }
}
