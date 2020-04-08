<?php

namespace App\Libraries;

use Illuminate\Support\Facades\DB;

class FrCodeGenerator
{
    public static function generate()
    {
        $alphaSeed = [
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H',
            'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R',
            'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        ];
        $numSeed   = [1, 2, 3, 4, 5, 6, 7, 8, 9];
        do {
            $alphaPicks = [
                rand(0, 23),
                rand(0, 23),
                rand(0, 23),
                rand(0, 23),
                rand(0, 23),
                rand(0, 23),
            ];
            $numPicks   = [
                rand(0, 8),
                rand(0, 8),
                rand(0, 8),
                rand(0, 8),
            ];
            $code = $alphaSeed[$alphaPicks[0]] .
                $alphaSeed[$alphaPicks[1]] .
                $numSeed[$numPicks[0]] .
                $alphaSeed[$alphaPicks[2]] .
                $alphaSeed[$alphaPicks[3]] .
                $numSeed[$numPicks[1]] .
                $alphaSeed[$alphaPicks[4]] .
                $alphaSeed[$alphaPicks[5]] .
                $numSeed[$numPicks[2]] .
                $numSeed[$numPicks[3]];
        } while (count(DB::table('users')->select('id')->where('fr_code', $code)->get()) > 0);
        return $code;
    }
}
