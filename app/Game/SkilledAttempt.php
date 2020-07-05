<?php

namespace App\Game;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\GameContract;
use App\Game\Contracts\PlayerContract;

class SkilledAttempt {

    private $game;

    private $player;

    private $action;

    private $chanceCalculator;

    /**
     * SkilledAttempt constructor.
     * @param GameContract $game
     * @param PlayerContract $player
     * @param ActionContract $action
     */
    public function __construct(GameContract $game, PlayerContract $player, ActionContract $action)
    {
        $this->game = $game;
        $this->player = $player;
        $this->action = $action;
    }

    public function attempt() : Outcome
    {
        $result = $this->game->dice()->roll();
        $chance = $this->getChanceCalculator()->getActionPercentage($this->action);

        $outcome = new Outcome($this->game);
        $outcome->setSuccessful(false);

        if ($result <= $chance) {
            $outcome->setRewards($this->action->getRewards());
            $outcome->setSuccessful(true);
        } else {
            $outcome->setPunishments($this->action->getPunishments());
        }

        return $outcome;
    }

    /**
     * @return ChanceCalculatorContract
     */
    private function getChanceCalculator() : ChanceCalculatorContract
    {
        if (is_null($this->chanceCalculator)) {
            return $this->game->defaultChanceCalculator($this->player);
        }

        return $this->chanceCalculator;
    }

    /**
     * @param ChanceCalculatorContract $chanceCalculator
     */
    public function setChanceCalculator(ChanceCalculatorContract $chanceCalculator): void
    {
        $this->chanceCalculator = $chanceCalculator;
    }
}