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

    // 100% chance of being discovered - left in as an example of ChanceDiscoveryContract
    public function getDiscoveryChance()
    {
        return 100;
    }

    /**
     * @param int $amount
     */
    private function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }
}