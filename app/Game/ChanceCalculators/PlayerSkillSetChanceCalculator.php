<?php

namespace App\Game\ChanceCalculators;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\PlayerContract;

class PlayerSkillSetChanceCalculator implements ChanceCalculatorContract {

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

        $skillSet = $player->getSkillSet(get_class($action));

        $playersSkill = $skillSet->points;
        $actionDifficulty = $action->getDifficulty();

        $adjustment = $playersSkill / $actionDifficulty;

        if ($adjustment <= 0) {
            return 0;
        }

        $defenceAdjustment = 1 / ($adjustment * $adjustment);

        $difficultyScore = $actionDifficulty * $defenceAdjustment;
        $playersChance = $playersSkill / $difficultyScore;
        $playersPercentage = round(min([$playersChance, 1]), 2);

        $randomOffsetPercentage = $this->getRandomOffsetPercentage($skillSet);

        $percentage = (1 - $randomOffsetPercentage) * $playersPercentage * 100;
        
        // round down to 100%
        if ($percentage > 100) {
            $percentage = 100;
        }

        return $percentage;
    }

    protected function getRandomOffsetPercentage($skillSet)
    {
        $randomOffset = $skillSet->chance_offset;

        return $randomOffset / 100;
    }
}