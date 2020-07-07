<?php

namespace App\Game;

use App\Game\Contracts\ChanceDiscoveryContract;
use App\Game\Contracts\GameContract;

class Outcome {

    private $game;

    private $rewards = [];

    private $punishments = [];

    private $successful = false;

    private $claimedCollection;

    /**
     * Outcome constructor.
     * @param GameContract $game
     */
    public function __construct(GameContract $game)
    {
        $this->game = $game;
    }

    /**
     * @param mixed $rewards
     */
    public function setRewards(array $rewards): void
    {
        $this->rewards = $rewards;
    }

    /**
     * @param mixed $punishments
     */
    public function setPunishments(array $punishments): void
    {
        $this->punishments = $punishments;
    }

    /**
     * @param bool $successful
     */
    public function setSuccessful(bool $successful): void
    {
        $this->successful = $successful;
    }

    public function claims()
    {
        // Ensure that the claims remain the same
        if (! is_null($this->claimedCollection)) {
            return $this->claimedCollection;
        }

        $claimCollection = new ClaimCollection();

        if ($this->wasSuccessful()) {
            $claimCollection->push(...$this->rewards);
        } else {
            $claimCollection->push(...$this->punishments);
        }

        $collectableClaims = $claimCollection->filter(function ($collectable) {
           if (! $collectable instanceof ChanceDiscoveryContract) {
               return true;
           }

            $collectable->attemptDiscovery($this->game->dice());

            return $collectable->wasDiscovered();

        })->map(function($collectable) {
            return $collectable;
        })->all();

        $this->claimedCollection = (new ClaimCollection($collectableClaims))->mapInto(Claim::class);

        return $this->claimedCollection;
    }

    public function wasSuccessful()
    {
        return $this->successful;
    }
}