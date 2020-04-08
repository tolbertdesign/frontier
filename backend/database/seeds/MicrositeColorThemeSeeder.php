<?php

use Illuminate\Database\Seeder;
use App\Entities\MicrositeColorTheme;

class MicrositeColorThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MicrositeColorTheme::insert([
            [
                'hex_code'   => '#004422',
                'theme_name' => 'dark_green_theme',
            ], [
                'hex_code'   => '#047548',
                'theme_name' => 'green_theme',
            ], [
                'hex_code'   => '#192461',
                'theme_name' => 'default_theme',
            ], [
                'hex_code'   => '#2ECC71',
                'theme_name' => 'light_green_theme',
            ], [
                'hex_code'   => '#2fc2ef',
                'theme_name' => 'light_blue_theme',
            ], [
                'hex_code'   => '#323232',
                'theme_name' => 'dark_gray_theme',
            ], [
                'hex_code'   => '#3338a8',
                'theme_name' => 'blue_theme',
            ], [
                'hex_code'   => '#684e79',
                'theme_name' => 'purple_theme',
            ], [
                'hex_code'   => '#710606',
                'theme_name' => 'dark_red_theme',
            ], [
                'hex_code'   => '#9ea8b2',
                'theme_name' => 'light_gray_theme',
            ], [
                'hex_code'   => '#b5151b',
                'theme_name' => 'red_theme',
            ], [
                'hex_code'   => '#ef852f',
                'theme_name' => 'light_orange_theme',
            ], [
                'hex_code'   => '#ff4522',
                'theme_name' => 'red_orange_theme',
            ]
        ]);
    }
}
