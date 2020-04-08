<?php

use Illuminate\Database\Seeder;
use App\Entities\Participant;
use App\Entities\Referrer;
use App\Entities\SpecialUrl;

class SpecialUrlSeeder extends Seeder
{
    private $first        = true;
    private $specialUrls  = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $participants = Participant::all();
        $referrers    = Referrer::all();
        $participants->each(function ($participant) use ($referrers) {
            $referrers->each(function ($referrer) use ($participant) {
                $slug = sha1($participant->user_id . '~' . $referrer->id . '~' . rand());
                $shortKey = strtr(base64_encode(pack('H*', substr($slug, 0, 12))), '+/', '-_');
                if ($this->first) { // make first key static to simplify testing
                    $this->first = false;
                    $shortKey = 'FFFFFFFF';
                }
                $this->specialUrls[] = [
                    'user_id'     => $participant->user_id,
                    'referrer_id' => $referrer->id,
                    'slug'        => $slug,
                    'short_key'   => $shortKey,
                ];
            });
        });
        SpecialUrl::insert($this->specialUrls);
    }
}
