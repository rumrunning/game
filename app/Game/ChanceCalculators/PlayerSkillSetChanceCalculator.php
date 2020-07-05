<?php

namespace App\Game\ChanceCalculators;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\PlayerContract;

class PlayerSkillSetChanceCalculator implements ChanceCalculatorContract {

    private $player;

    /**
     * PlayerSkillSetChanceCalculator constructor.
     * @param PlayerContract $player
     */
    public function __construct(PlayerContract $player)
    {
        $this->player = $player;
    }

    public function getActionPercentage(ActionContract $action)
    {
        $skill = $this->player->getSkillSetPoints(get_class($action));
        $actionChance = 1 - $action->getDifficulty();


        $percentage = $skill * $actionChance * 100;

        // round down to 100%
        // @todo Work out how to set a value between 9X% & 100%, without the odds changing on page refresh
        if ($percentage > 100) {
            $percentage = 100;
        }

        return $percentage;
    }
}