<?php

use Illuminate\Database\Seeder;
use App\Entities\Meta;

class MetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meta::insert([
            [
                'name'  => 'access_token',
                'value' => '00DU0000000HZd8!AR8AQEaqpDxVi6zemBxHI8svUr.WFwfJ5xeXVp' .
                    'RD86Reax.VUOEnSe08YvPLYIMVXsMIyheVYlOy0uZwnwRBgHmsOXIM1qPB',
            ],
            [
                'name'  => 'instance_url',
                'value' => 'https://boosterthon.my.salesforce.com',
            ],
            [
                'name'  => 'api_user',
                'value' => null,
            ],
            [
                'name'  => 'api_password',
                'value' => null,
            ],
            [
                'name'  => 'program_pull_timestamp',
                'value' => '1375062177',
            ],
            [
                'name'  => 'schools_pull_timestamp',
                'value' => '1373917588',
            ],
            [
                'name'  => 'groups_pull_timestamp',
                'value' => '1515683703',
            ],
            [
                'name'  => 'contacts_pull_timestamp',
                'value' => '1364067002',
            ],
            [
                'name'  => 'flag_limit',
                'value' => '90',
            ],
            [
                'name'  => 'flag_high_donation',
                'value' => '90',
            ],
            [
                'name'  => 'flag_high_ppu',
                'value' => '90',
            ],
            [
                'name'  => 'flag_high_cumulative_per_day',
                'value' => '150',
            ],
            [
                'name'  => 'flag_high_quantity_per_day',
                'value' => '5',
            ],
            [
                'name'  => 'default_pledge_period_time',
                'value' => 'PT8H00M',
            ],
            [
                'name'  => 'default_period_quantity',
                'value' => '7',
            ],
            [
                'name'  => 'group_pull_timestamp',
                'value' => '1503596328',
            ],
            [
                'name'  => 'default_num_laps',
                'value' => '30',
            ],
            [
                'name'  => 'workers_pull_timestamp',
                'value' => '1503596322',
            ],
            [
                'name'  => 'default_outstanding_amt',
                'value' => '4',
            ],
            [
                'name'  => 'flat_donate_only',
                'value' => '0',
            ],
            [
                'name'  => 'flag_payment_scheduled_high_value',
                'value' => '150',
            ],
            [
                'name'  => 'weekend_challenge_amount',
                'value' => '2',
            ],
            [
                'name'  => 'family_pledging_enabled',
                'value' => '1',
            ]
        ]);
    }
}
