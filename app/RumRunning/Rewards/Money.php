<?php

namespace App\RumRunning\Rewards;

use App\Game\Reward;

class Money extends RangeReward {

    private $amount = 0;

    public function collect()
    {
        $this->setAmount($this->randomReward());

        return $this->amount;
    }

    /**
     * @param int $amount
     */
    private function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}