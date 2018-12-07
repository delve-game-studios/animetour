<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayersSetting extends Model
{
    protected $guarded = ['id'];
    protected $with = ['user', 'video'];
    protected $casts = ['is_paused' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id', 'id');
    }
}
