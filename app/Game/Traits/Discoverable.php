<?php

namespace App\Game\Traits;

use App\Game\Contracts\DiceContract;

trait Discoverable {

    private $discoveryChance = 0;

    private $discovered = false;

    public function setDiscoveryChance($chance)
    {
        $this->discoveryChance = $chance;

        return $this;
    }

    public function getDiscoveryChance()
    {
        return round($this->discoveryChance * 100, 2);
    }

    public function attemptDiscovery(DiceContract $dice)
    {
        $roll = $dice->roll();

        $this->discovered = $roll <= $this->getDiscoveryChance();
    }

    public function wasDiscovered(): bool
    {
        return $this->discovered;
    }
}