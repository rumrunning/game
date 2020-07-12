<?php

namespace App;

use App\Game\Contracts\PlayerContract;
use Illuminate\Database\Eloquent\Model;

class Timer extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type', 'ends_at',
    ];

    public function player()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForPlayer($query, PlayerContract $player)
    {
        $query->where('user_id', $player->getKey());
    }

    public function scopeType($query, string $timer)
    {
        $query->where('type', $timer);
    }
}
