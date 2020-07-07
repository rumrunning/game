<?php

namespace App\Game\ChanceCalculators;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\PlayerContract;
use App\Game\Contracts\PlayerRequired;
use App\Game\Exceptions\PlayerNotSetException;
use App\Game\Traits\InteractsAsPlayer;

class PlayerSkillSetChanceCalculator implements ChanceCalculatorContract, PlayerRequired {

    use InteractsAsPlayer;

    public function getActionPercentage(ActionContract $action)
    {
        $player = $this->getPlayer();

        if (is_null($player)) {
            throw new PlayerNotSetException("You need to set a player first. Try adding 'asPlayer' method.");
        }

        $skill = $player->getSkillSetPoints(get_class($action));
        $actionChance = 1 - $action->getDifficulty();


        $percentage = round($skill * $actionChance * 100, 2);

        // round down to 100%
        // @todo Work out how to set a value between 9X% & 100%, without the odds changing on page refresh
        if ($percentage > 100) {
            $percentage = 100;
        }

        return $percentage;
    }
}