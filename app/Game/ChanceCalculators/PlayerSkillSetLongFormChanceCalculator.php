<?php

namespace App\Game\ChanceCalculators;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;
use App\RumRunning\Contracts\PlayerContract;

class PlayerSkillSetLongFormChanceCalculator implements ChanceCalculatorContract {

    /**
     * @var PlayerContract $player
     */
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
        $player = $this->player;

        $playersSkill = $player->getSkillSetPoints(get_class($action));
        $actionDifficulty = 1 - $action->getDifficulty();

        $adjustment = $playersSkill / $actionDifficulty;

        if ($adjustment <= 0) {
            return 0;
        }

        $defenceAdjustment = 1 / $adjustment * $adjustment;

        $difficultyScore = $actionDifficulty * $defenceAdjustment;
        $playersChance = $playersSkill / $difficultyScore;
        $playersPercentage = round(min([$playersChance, 1]), 2);

        $offsetScore = 55 - $adjustment * 50;
        $offsetScoreAdjusted = max($offsetScore, 5);

        $randomOffset = random_int(0, $offsetScoreAdjusted);
        $randomOffsetPercentage = $randomOffset / 100;

        $percentage = (1 - $randomOffsetPercentage) * $playersPercentage * 100;

        // round down to 100%
        // @todo Work out how to set a value between 9X% & 100%, without the odds changing on page refresh
        if ($percentage > 100) {
            $percentage = 100;
        }

        return $percentage;
    }
}