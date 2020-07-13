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
        return $query->where('class', $class);
    }

    public function getPointsAttribute()
    {
        return $this->attributes['points'] / 1000;
    }

    public function setPointsAttribute($value)
    {
        return $this->attributes['points'] = $value * 1000;
    }

    public function increasePoints($points)
    {
        $this->points += $points;

        $this->save();
    }
}
