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

        $adjustment = $playerSkill / $actionDifficulty;

        $offsetScore = 55 - $adjustment * 50;
        $offsetScoreAdjusted = max([$offsetScore, 5]);

        return random_int(0, $offsetScoreAdjusted);
    }
}