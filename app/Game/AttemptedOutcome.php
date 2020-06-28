<?php

namespace App\Game;

class AttemptedOutcome {

    private $rewards = [];

    private $punishments = [];

    private $successful = false;

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

    public function claim()
    {
        foreach ($this->rewards as $reward) {
            var_dump($reward['class']->collect(), get_class($reward['class']));
        }
    }

    public function wasSuccessful()
    {
        return $this->successful;
    }
}