<?php

namespace App\Game;

class Dice {

    public function roll($min = 1, $max = 100)
    {
        $min = $min * 1000;
        $max = $max * 1000;

        $random = random_int($min, $max);

        return round($random / 1000, 2);
    }
}