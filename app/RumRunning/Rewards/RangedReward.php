<?php

namespace App\RumRunning\Rewards;

use App\Game\Reward;

abstract class RangedReward extends Reward {

    private $maxValue;

    private $value;

    /**
     * Money constructor.
     */
    public function __construct($value, $maxValue = null)
    {
        $this->value = $value;

        $this->maxValue = $maxValue;

        if (is_null($this->maxValue)) {
            $this->maxValue = $value;
        }
    }

    protected function randomReward()
    {
        return random_int($this->value, $this->maxValue);
    }
}