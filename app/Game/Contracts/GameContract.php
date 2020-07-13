<?php

namespace App\Game\Contracts;

interface GameContract {

    public function name();

    public function dice();

    public function startTimer(PlayerContract $player, string $timer, int $seconds) : TimerModelContract;

    public function waitingForTimer(PlayerContract $player, string $timer) : bool;
}