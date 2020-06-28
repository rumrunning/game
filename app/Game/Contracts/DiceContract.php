<?php

namespace App\Game\Contracts;

interface DiceContract {

    public function roll($min = 1, $max = 100);
}