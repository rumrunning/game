<?php

namespace App\Game;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\GameContract;
use App\Game\Contracts\PlayerContract;
use App\Game\Contracts\PlayerRequired;

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
        $action = $this->action;

        $result = $this->game->dice()->roll();
        $chance = $this->player->getActionChanceCalculator($action)->getActionPercentage($action);

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
}