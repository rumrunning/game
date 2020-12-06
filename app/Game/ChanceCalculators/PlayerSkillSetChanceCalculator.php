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

    /**
     * @param ActionContract $action
     * @return float
     */
    public function getActionPercentage(ActionContract $action) : float
    {
        $player = $this->player;

        $skillSet = $player->getSkillSet(get_class($action));

        $playersSkill = $skillSet->points;
        $actionDifficulty = $action->getDifficulty();

        $playersPercentage = $this->calculatePlayersPercentage($playersSkill, $actionDifficulty);

        $randomOffsetPercentage = $this->getRandomOffsetPercentage($skillSet);

        $percentage = $this->calculateFinalPercentage($randomOffsetPercentage, $playersPercentage);

        return $percentage;
    }

    protected function getRandomOffsetPercentage($skillSet)
    {
        $randomOffset = $skillSet->chance_offset;

        return bcdiv($randomOffset, 100, 2);
    }

    protected function calculateFinalPercentage($randomOffsetPercentage, $playersPercentage)
    {
        $percentage = bcsub(1, $randomOffsetPercentage, 8);
        $percentage = bcmul($percentage, $playersPercentage, 8);
        $percentage = bcmul($percentage, 100, 8);

        if ($percentage >= 100) {
            $percentage = 100;
        }

        return (float) $percentage;
    }

    protected function calculatePlayersPercentage($playersSkill, $actionDifficulty)
    {
        $adjustment = (float) bcdiv($playersSkill, $actionDifficulty, 8);

        if ($adjustment <= 0) {
            return 0;
        }

        $adjustment = (float) bcmul($adjustment, $adjustment, 32);
        $defenceAdjustment = (float) bcdiv(1, $adjustment, 32);

        $difficultyScore = (float) bcmul($actionDifficulty, $defenceAdjustment, 32);
        $playersChance = (float) bcdiv($playersSkill, $difficultyScore, 32);

        return min([$playersChance, 1]);
    }
}
