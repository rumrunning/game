<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkillSet extends Model {

    public $timestamps = false;

    public function player()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeGetSkillSet($query, $class)
    {
        $query->where('class', $class);
    }

    public function getPointsAttribute($value)
    {
        return (float) bcdiv($value, 1000, 2);
    }

    public function setPointsAttribute($value)
    {
        $this->attributes['points'] = (int) bcmul($value, 1000);
    }

    public function increasePoints($points)
    {
        $this->increment('points', $points);
    }
}
