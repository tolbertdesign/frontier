<?php

use Illuminate\Database\Seeder;
use App\Entities\Referrer;

class ReferrerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Referrer::insert([
            [
                'name'     => 'Facebook',
                'source'   => 'facebook.com',
                'medium'   => 'social',
                'content'  => 'nossvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => 'Twitter',
                'source'   => 'twitter.com',
                'medium'   => 'social',
                'content'  => 'nossvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => 'Email',
                'source'   => 'emailtemp',
                'medium'   => 'email',
                'content'  => 'nossvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => 'Link',
                'source'   => 'unknown',
                'medium'   => 'link',
                'content'  => 'nossvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => 'SMS',
                'source'   => 'text',
                'medium'   => 'text',
                'content'  => 'nossvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => 'EE_enrollment',
                'source'   => 'eeenrollment',
                'medium'   => 'email',
                'content'  => 'nossvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => 'EE_day_before',
                'source'   => 'eedaybefore',
                'medium'   => 'email',
                'content'  => 'nossvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'      => 'EE_day_after',
                 'source'   => 'eedayafter',
                 'medium'   => 'email',
                 'content'  => 'nossvideo',
                 'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => 'Facebook_Video',
                'source'   => 'facebook.com',
                'medium'   => 'social',
                'content'  => 'ssvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => 'Email_Video',
                'source'   => 'emailtemp',
                'medium'   => 'email',
                'content'  => 'ssvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => 'Link_Video',
                'source'   => 'unknown',
                'medium'   => 'link',
                'content'  => 'ssvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => 'SMS_Video',
                'source'   => 'text',
                'medium'   => 'text',
                'content'  => 'ssvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => '24_no_pledge_email',
                'source'   => 'autoparentemail',
                'medium'   => 'email',
                'content'  => null,
                'campaign' => 'nopledgeafter24_public'
            ], [
                'name'     => 'EE_enrollment_video',
                'source'   => 'eeenrollment',
                'medium'   => 'email',
                'content'  => 'ssvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'     => 'EE_day_after_video',
                'source'   => 'eedayafter',
                'medium'   => 'email',
                'content'  => 'ssvideo',
                'campaign' => 'sponsorpledgeask'
            ], [
                'name'      => 'EE_day_before_video',
                'source'    => 'eedaybefore',
                'medium'    => 'email',
                'content'   => 'ssvideo',
                'campaign'  => 'sponsorpledgeask'
            ], [
                'name'      => 'Student_star_prompt',
                'source'    => 'autoparentemail',
                'medium'    => 'email',
                'content'   => null,
                'campaign'  => 'createstudentstar'
            ], [
                'name'     => '24_no_pledge_email_private',
                'source'   => 'autoparentemail',
                'medium'   => 'email',
                'content'  => null,
                'campaign' => 'nopledgeafter24_private'
            ], [
                'name'     => 'Share_facebook_prompt',
                'source'   => 'autoparentemail',
                'medium'   => 'email',
                'content'  => null,
                'campaign' => 'shareonfacebook'
            ], [
                'name'     => 'unpaid_sponsor_email_1',
                'source'   => 'unpaidsponsoremail1',
                'medium'   => 'email',
                'content'  => null,
                'campaign' => 'sponsorpayment'
            ], [
                'name'     => 'unpaid_sponsor_email_2',
                'source'   => 'unpaidsponsoremail2',
                'medium'   => 'email',
                'content'  => null,
                'campaign' => 'sponsorpayment'
            ],
        ]);
    }
}
