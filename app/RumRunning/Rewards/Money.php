<?php

namespace App\RumRunning\Rewards;

use App\Game\Contracts\ChanceDiscoveryContract;
use App\Game\Traits\Discoverable;

class Money extends RangedReward implements ChanceDiscoveryContract {

    use Discoverable;

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