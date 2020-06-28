<?php

namespace App\Game;

use App\Game\Contracts\GameContract;

class Outcome {

    private $game;

    private $rewards = [];

    private $punishments = [];

    private $successful = false;

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
        $claimCollection = new ClaimCollection();

        if ($this->wasSuccessful()) {
            $claimCollection->push(...$this->rewards);
        } else {
            $claimCollection->push(...$this->punishments);
        }

        $collectableClaims = $claimCollection->filter(function ($claim) {
            $result = $claim['chance'] * 100;
            $roll = $this->game->dice()->roll();

            return $roll <= $result;
        })->map(function($claim) {
            return $claim['class'];
        })->all();

        $claimCollection = (new ClaimCollection($collectableClaims))->mapInto(Claim::class);

        return $claimCollection;
    }

    public function wasSuccessful()
    {
        return $this->successful;
    }
}