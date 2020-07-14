<?php

namespace App\RumRunning\Contracts;

use App\Game\Contracts\PlayerContract as BasePlayerContract;
use App\Game\Outcome;
use App\RumRunning\Crimes\Crime;

interface PlayerContract extends BasePlayerContract {

    public function attemptCrime(Crime $crime) : Outcome;

    public function collectMonies($monies);
}