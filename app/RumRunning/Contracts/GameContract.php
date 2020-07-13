<?php

namespace App\RumRunning\Contracts;

use App\Game\Contracts\GameContract as BaseGameContract;
use App\Game\Outcome;
use App\RumRunning\Crimes\Crime;
use App\RumRunning\Crimes\CrimeCollection;

interface GameContract extends BaseGameContract {

    /**
     * @return CrimeCollection
     */
    public function crimes(): CrimeCollection;

    public function setCrimes(CrimeCollection $crimes);

    public function attemptCrime(PlayerContract $player, Crime $crime) : Outcome;

}