<?php

namespace App\Game;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\PlayerContract;

class ActionChanceOffsetCalculator {

    /**
     * @var ActionContract $action
     */
    private $action;

    /**
     * ActionChanceOffsetCalculator constructor.
     * @param ActionContract $action
     */
    public function __construct(ActionContract $action)
    {
        $this->action = $action;
    }

    public function calculate(PlayerContract $player)
    {
        $playerSkill = $player->getSkillSetPoints(get_class($this->action));
        $actionDifficulty = $this->action->getDifficulty();

        $adjustment = (float) bcdiv($playerSkill, $actionDifficulty, 2);

        $offsetScore = bcmul($adjustment, 50, 2);
        $offsetScore = bcsub(55, $offsetScore, 2);
        $offsetScoreAdjusted = round(max([$offsetScore, 5]), 2);

        return random_int(0, $offsetScoreAdjusted);
    }
}
