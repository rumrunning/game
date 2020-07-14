<?php

namespace App\RumRunning\Rewards;

use App\Game\ClaimsCollector;
use App\Game\Contracts\ActionRandomisesChanceContract;

class Skill extends RangedReward {

    private $total = 0;

    public function prepareForCollection()
    {
        $this->setTotal($this->randomReward());

        return $this->total;
    }

    /**
     * @param int $total
     */
    private function setTotal(int $total): void
    {
        $this->total = $total / 1000;
    }

    public function collect($value, ClaimsCollector $claimsCollector)
    {
        $player = $claimsCollector->getPlayer();
        $action = $claimsCollector->getAction();

        $skillSet = $player->getSkillSet(get_class($action));

        $skillSet->points += $value;

        if ($action instanceof ActionRandomisesChanceContract) {
            $skillSet->chance_offset = $action->getChanceOffsetCalculator()->calculate($player);
        }

        $skillSet->save();
    }
}