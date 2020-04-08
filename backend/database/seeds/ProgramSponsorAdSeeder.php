<?php

use Illuminate\Database\Seeder;
use App\Entities\ProgramSponsor;
use App\Entities\ProgramSponsorAd;

class ProgramSponsorAdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $programSponsor   = ProgramSponsor::find(1);
        $programSponsorAd = new ProgramSponsorAd([
            'id'                 => 1,
            //@codingStandardsIgnoreLine
            'ad_text'            => '<div style="display:inline-block;"><div style="float:left; width:400px;max-width:100%;"><b>Start saving for your child\'s college fund today!</b> The test Fun Run has partnered with The Florida Prepaid College Board to help you get a jump start on saving for college. Click the Learn More to get started!</div><div style="float:left;width:200px;margin-left:10px;min-width:200px;max-width:100%;"><img style="min-width:200px;max-width:100%;" src="/assets/images/fpp_logo_color.png"/><center style="margin-top:10px;"><a class="btn btn-danger" href="/a/t/1?q=http%3A%2F%2Fwww.myfloridaprepaid.com"/>LEARN MORE</a></center></div></div>'
        ]);
        $programSponsor->programSponsorAds()->save($programSponsorAd);
        $programSponsorAd = new ProgramSponsorAd([
            'id'                 => 2,
            //@codingStandardsIgnoreLine
            'ad_text'            => 'Start saving for your child\'s colledge fund today! The test Fun Run has partnered with The Florida Prepaid College Board to help you get a jump start on saving for college. Visit <a href="${BASE_URL}a/t/${PROGRAM_SPONSOR_AD_LOCATION_ID}?q=http%3A%2F%2Fwww.myfloridaprepaid.com">MyFloridaPrepaid.com</a> to get started.'
        ]);
        $programSponsor->programSponsorAds()->save($programSponsorAd);
        $programSponsorAd = new ProgramSponsorAd([
            'id'                 => 3,
            //@codingStandardsIgnoreLine
            'ad_text'            => '<div><div style="float:left; width:100%;padding-bottom:10px;"><b>Start saving for your child\'s college fund today!</b> The test Fun Run has partnered with The Florida Prepaid College Board to help you get a jump start on saving for college. Enter to win one of five $1000 Florida Prepaid college scholarships! Click Learn More to get started!</div><div style="float:left;width:100%;text-align:center;"><img style="max-width:100%;" src="/assets/images/fpp_logo_color.png"/><center style="margin-top:10px;"><a class="btn btn-danger" href="/a/t/1?q=http%3A%2F%2Fwww.myfloridaprepaid.com%2Fboosterthon"/>LEARN MORE</a></center></div></div>'
        ]);
        $programSponsor->programSponsorAds()->save($programSponsorAd);
    }
}
