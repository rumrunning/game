<?php

namespace App;

use App\Game\Contracts\PlayerContract;
use App\Game\Traits\InteractsWithGame;
use App\RumRunning\Crimes\Crime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements PlayerContract
{
    use HasApiTokens, Notifiable, InteractsWithGame;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function attemptCrime(Crime $crime)
    {
        return $this->game()->commitCrime($this, $crime);
    }

    public function getSkill($kind)
    {
        if ($kind === Crime::class) {
            return 0.9;
        }

        return 0;
    }
}
