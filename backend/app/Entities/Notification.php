<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Stevebauman\Purify\Facades\Purify;

class Notification extends Model
{
    public $incrementing = false;

    const TYPE_PROGRAM = 'ProgramAlert';
    const TYPES = [
        self::TYPE_PROGRAM
    ];

    protected $casts = [
        'starts_at' => 'datetime:c',
        'ends_at' => 'datetime:c'
    ];

    protected $guarded = [];

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public function getDataAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Prevents getting notifications outside of the start/end dates
        static::addGlobalScope('ends_at', function (Builder $builder) {
            $builder->where('starts_at', '<', Carbon::now());
            $builder->where('ends_at', '>', Carbon::now());
        });
    }

    /**
     * Remove expired notifications.
     *
     * @return  Collection
     */
    public static function removeExpiredNotifications($notifications)
    {
        return $notifications->filter(function ($notification) {
            $now = Carbon::now();
            return $notification->starts_at < $now && $notification->ends_at > $now;
        });
    }

    public function getCleanHtmlMessageAttribute()
    {
        $cachePath = base_path('bootstrap/cache');

        $config = [
            'Core.Encoding'             => 'utf-8',
            'HTML.Doctype'              => 'HTML 4.01 Transitional',
            'HTML.Allowed'              => 'p,strong,b,em,i,li,ol,ul,a[href],a[target],br,div,span,u',
            'HTML.TidyLevel'            => 'light',
            'AutoFormat.RemoveEmpty'    => true,
            'Cache.SerializerPath'      => $cachePath,
            'Attr.AllowedFrameTargets'  => ['_blank', '_self', '_parent', '_top']
        ];

        $data = $this->data;

        if ($data && property_exists($data, 'content')) {
            return Purify::clean($data->content, $config);
        } else {
            return '';
        }
    }
}
