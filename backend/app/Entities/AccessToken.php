<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccessToken extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'access_token',
        'expires_at',
        'redirect'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Access token is valid if it is not expired & it belongs to the user being requested.
     */
    public static function getValidatedToken(int $userId, string $accessToken)
    {
        $obj = self::where([
            ['access_token', '=', $accessToken],
            ['user_id', '=', $userId],
            ['expires_at', '>', DB::raw("NOW()")]
        ])->first();
        return is_object($obj) && $obj->exists ? $obj:null;
    }

    /**
     * Access token is valid if it is not expired
     */
    public static function getInternalValidatedToken(string $accessToken)
    {
        $obj = self::where([
            ['access_token', '=', $accessToken],
            ['expires_at', '>', DB::raw("NOW()")]
        ])->first();
        return is_object($obj) && $obj->exists ? $obj:null;
    }
}
