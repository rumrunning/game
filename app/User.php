<?php

namespace App;

use App\Game\ChanceCalculators\PlayerSkillSetChanceCalculator;
use App\Game\Claim;
use App\Game\ClaimCollection;
use App\Game\ClaimsCollector;
use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;
use App\RumRunning\Contracts\PlayerContract;
use App\Game\Outcome;
use App\Game\Traits\InteractsWithGame;
use App\RumRunning\Crimes\Crime;
use App\RumRunning\Rewards\Money;
use App\RumRunning\Rewards\Skill;
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
        'monies' => 'integer',
    ];

    /**
     * @var ChanceCalculatorContract $defaultActionChanceCalculator
     */
    private $defaultActionChanceCalculator;

    /**
     * User constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->defaultActionChanceCalculator = new PlayerSkillSetChanceCalculator($this);
    }

    public function attemptCrime(Crime $crime) : Outcome
    {
        return $this->game()->attemptCrime($this, $crime);
    }

    public function timers()
    {
        return $this->hasMany(Timer::class);
    }

    public function skillSets()
    {
        return $this->hasMany(SkillSet::class);
    }

    public function getSkillSet($class) : SkillSet
    {
        return $this->skillSets()->getSkillSet($class)->first();
    }

    public function getSkillSetPoints($class)
    {
        if ($class instanceof ActionContract) {
            $class = get_class($class);
        }

        return $this->getSkillSet($class)->points;
    }

    public function getActionChanceCalculator($class) : ChanceCalculatorContract
    {
        if ($class instanceof ActionContract) {
            $class = get_class($class);
        }

        switch ($class) {
            default:
                return $this->getDefaultActionChanceCalculator();
        }
    }

    /**
     * @return ChanceCalculatorContract
     */
    public function getDefaultActionChanceCalculator(): ChanceCalculatorContract
    {
        return $this->defaultActionChanceCalculator;
    }

    /**
     * @param ChanceCalculatorContract $defaultActionChanceCalculator
     */
    public function setDefaultActionChanceCalculator(ChanceCalculatorContract $defaultActionChanceCalculator): void
    {
        $this->defaultActionChanceCalculator = $defaultActionChanceCalculator;
    }

    public function collectMonies($monies)
    {
        $this->increment('monies', $monies);
    }

    public function collectClaimsFor(ActionContract $action, ClaimCollection $claims)
    {
        $this->claimsCollector($action, $claims)->collect();
    }

    private function claimsCollector(ActionContract $action, ClaimCollection $claims)
    {
        return new ClaimsCollector($claims, $this, $action);
    }
}
