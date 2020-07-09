<?php

namespace App\RumRunning;

use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\DiceContract;
use App\Game\Game as BaseGame;
use App\Game\Contracts\PlayerContract;
use App\RumRunning\Crimes\Crime;
use App\RumRunning\Crimes\CrimeCollection;

class Game extends BaseGame {

    private $name;

    private $crimes;

    /**
     * @return CrimeCollection
     */
    public function crimes(): CrimeCollection
    {
        return $this->crimes;
    }

    public function setCrimes(CrimeCollection $crimes)
    {
        $this->crimes = $crimes;
    }

    public function attemptCrime(PlayerContract $player, Crime $crime)
    {
        $attempt = $this->skilledAttemptBy($player, $crime);

        return $attempt->attempt();
    }
}