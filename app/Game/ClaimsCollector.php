<?php

namespace App\Game;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\PlayerContract;

class ClaimsCollector {

    /**
     * @var ClaimCollection $claimCollection
     */
    private $claimCollection;

    /**
     * @var PlayerContract $player
     */
    private $player;

    /**
     * @var ActionContract $action
     */
    private $action;

    /**
     * ClaimsCollector constructor.
     * @param ClaimCollection $claimCollection
     * @param PlayerContract $player
     * @param ActionContract $action
     */
    public function __construct(ClaimCollection $claimCollection, PlayerContract $player, ActionContract $action)
    {
        $this->claimCollection = $claimCollection;
        $this->player = $player;
        $this->action = $action;
    }

    public function collect()
    {
        $this->claimCollection->each(function (Claim $claim) {
            $this->collectClaim($claim);
        });
    }

    /**
     * @return PlayerContract
     */
    public function getPlayer(): PlayerContract
    {
        return $this->player;
    }

    /**
     * @return ActionContract
     */
    public function getAction(): ActionContract
    {
        return $this->action;
    }

    private function collectClaim(Claim $claim)
    {
        $claim->getCollectable()->collect($claim->getValue(), $this);
    }
}