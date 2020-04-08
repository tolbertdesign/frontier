<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Entities\Video;

class VideoCategory extends Model
{
    protected $table = 'video_categories';

    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
