<?php

namespace App\RumRunning;

use App\Game\Contracts\DiceContract;
use App\Game\Game as BaseGame;
use App\Game\Contracts\ActionContract;
use App\Game\Contracts\PlayerContract;
use App\RumRunning\Crimes\Crime;
use App\RumRunning\Crimes\CrimesCollection;

class Game extends BaseGame {

    private $name;

    private $crimes;

    /**
     * Game constructor.
     * @param string $name
     * @param DiceContract $dice
     * @param array $chanceCalculators
     * @param CrimesCollection $crimes
     */
    public function __construct(string $name,
                                DiceContract $dice,
                                array $chanceCalculators,
                                CrimesCollection $crimes)
    {
        parent::__construct($name, $dice, $chanceCalculators);

        $this->crimes = $crimes;
    }

    /**
     * @return CrimesCollection
     */
    public function crimes(): CrimesCollection
    {
        return $this->crimes;
    }

    public function attemptCrime(PlayerContract $player, Crime $crime)
    {
        return $this->skilledAttemptBy($player, $crime)->attempt();
    }
}