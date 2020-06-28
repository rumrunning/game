<?php

namespace App\Game;

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
        if ($percentage > 100) {
            $percentage = 100;
            // @todo consider making this variable
            // $percentage = 100 - random_int(0, $action->getDifficulty() * 100);
        }

        return $percentage;
    }
}