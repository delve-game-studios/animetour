<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analytic extends Model
{
    protected $with = ['type'];

    public static function get($attributes)
    {
        return static::firstOrNew($attributes);
    }

    public function type()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
