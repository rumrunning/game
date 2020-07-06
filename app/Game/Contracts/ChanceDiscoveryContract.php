<?php

namespace App\Game\Contracts;

interface ChanceDiscoveryContract {

    // Should be no more than 1 as it will be used as a percentage and multiplied by 100
    public function setDiscoveryChance($chance);

    public function getDiscoveryChance();

    public function attemptDiscovery(DiceContract $dice);

    public function wasDiscovered() : bool;
}