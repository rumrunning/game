<?php

namespace App\RumRunning;

use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\DiceContract;
use App\Game\Game as BaseGame;
use App\Game\Contracts\PlayerContract;
use App\RumRunning\Crimes\Crime;
use App\RumRunning\Crimes\CrimesCollection;

class Game extends BaseGame {

    private $name;

    private $crimes;

    /**
     * @return CrimesCollection
     */
    public function crimes(): CrimesCollection
    {
        return $this->crimes;
    }

    public function setCrimes(CrimesCollection $crimes)
    {
        $this->crimes = $crimes;
    }

    public function attemptCrime(PlayerContract $player, Crime $crime, ChanceCalculatorContract $chanceCalculator = null)
    {
        $attempt = $this->skilledAttemptBy($player, $crime);
        $attempt->setChanceCalculator($chanceCalculator);

        return $attempt->attempt();
    }
}