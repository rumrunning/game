<?php

namespace App\Game\Contracts;

use Carbon\Carbon;

interface TimerRepositoryContract {

    public function forPlayer(PlayerContract $player) : TimerRepositoryContract;

    public function setUntil(string $timer, Carbon $carbon) : void;
}