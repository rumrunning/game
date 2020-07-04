<?php

namespace App\RumRunning\Rewards;

class Skill extends RangedReward {

    private $total = 0;

    public function collect()
    {
        $this->setTotal($this->randomReward());

        return $this->total;
    }

    /**
     * @param int $total
     */
    private function setTotal(int $total): void
    {
        $this->total = $total / 100;
    }
}