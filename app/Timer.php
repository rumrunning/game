<?php

namespace App;

use App\Game\Contracts\PlayerContract;
use App\Game\Contracts\TimerModelContract;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Timer extends Model implements TimerModelContract {

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type', 'ends_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ends_at' => 'datetime',
    ];

    public function player()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeForPlayer($query, PlayerContract $player)
    {
        $query->where('user_id', $player->getKey());
    }

    public function scopeType($query, string $timer)
    {
        $query->where('type', $timer);
    }

    public function getEndsAt(): ?Carbon
    {
        return $this->ends_at;
    }
}
