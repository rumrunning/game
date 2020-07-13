<?php

namespace App\RumRunning;

use App\Game\Game as BaseGame;
use App\RumRunning\Contracts\GameContract;
use App\RumRunning\Contracts\PlayerContract;
use App\Game\Outcome;
use App\RumRunning\Crimes\Crime;
use App\RumRunning\Crimes\CrimeCollection;

class Game extends BaseGame implements GameContract {

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

    public function attemptCrime(PlayerContract $player, Crime $crime) : Outcome
    {
        $this->beforeAttempt($player, $crime);

        $attempt = $this->skilledAttemptBy($player, $crime);

        $outcome = $attempt->attempt();

        $this->afterAttempt($player, $crime, $outcome);

        return $outcome;
    }
}