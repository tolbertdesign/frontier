<?php

use Illuminate\Database\Seeder;
use App\Entities\Microsite;

class MicrositeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logos = collect([
            [ 'filename' => '2000px-Georgia_Athletics_logo.svg.png'],
            [ 'filename' => 'logo2.png'],
            [ 'filename' => 'logo3.png'],
            [ 'filename' => 'logo4.png'],
            [ 'filename' => 'school logo.jpg'],
            [ 'filename' => 'School logo2.jpg']
        ]);

        $microsite = new Microsite([
            'program_id'               => 1,
            'intro_vid_override'       => '0',
            'video_1'                  => 1,
            'video_2'                  => 2,
            'video_3'                  => 3,
            'video_4'                  => 4,
            'video_5'                  => 5,
            'slug'                     => 'salesforce-test-25',
            'pic_1'                    => 1,
            'pic_2'                    => 2,
            'pic_3'                    => null,
            'parents_invited'          => 0,
            'last_updated'             => '2016-09-27 13:01:12',
            'hide_character_videos'    => null,
            'overview_text_override'   => '',
            'school_image_name'        => $logos->random()['filename'],
            'color_theme_id'           => 1,
            'funds_raised_for'         => 'ipads &amp; more ipads',
            'get_pledges_vid_override' => 0,
        ]);
        $microsite->save();
    }
}
