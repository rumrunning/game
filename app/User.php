<?php

namespace App;

use App\Game\ChanceCalculators\PlayerSkillSetChanceCalculator;
use App\Game\Claim;
use App\Game\ClaimCollection;
use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\PlayerContract;
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

    public function attemptCrime(Crime $crime)
    {
        return $this->game()->attemptCrime($this, $crime);
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

    public function collectClaimsFor(ActionContract $action, ClaimCollection $claims)
    {
        $claims->each(function ($claim) use ($action) {
            $this->collectClaimFor($action, $claim);
        });
    }

    private function collectClaimFor(ActionContract $action, Claim $claim)
    {
        switch (get_class($claim->getCollectable())) {
            case Skill::class:
                $skillPoints = $claim->getValue();

                $this->collectSkillPointsFor($action, $skillPoints);
                break;
            case Money::class:
                $monies = $claim->getValue();

                $this->collectMoniesFor($action, $monies);
                break;
        }
    }

    private function collectSkillPointsFor(ActionContract $action, $points)
    {
        $this->getSkillSet(get_class($action))->increasePoints($points);
    }

    private function collectMoniesFor(ActionContract $action, $monies)
    {
        $this->increment('monies', $monies);
    }
}
