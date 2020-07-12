<?php

namespace App\Game\Contracts;

interface TimerRestrictedContract {

    public function getTimer();

    public function getTimerDuration();
}