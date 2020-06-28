<?php

namespace App\Game;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\GameContract;
use App\Game\Contracts\PlayerContract;

class SkilledAttempt {

    private $game;

    private $player;

    private $action;

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

    public function attempt()
    {
        $result = $this->game->dice()->roll();
        $chance = $this->getPercentageChance();

        $outcome = new AttemptedOutcome();

        if ($result <= $chance) {
            $outcome->setRewards($this->action->getRewards());
            $outcome->setSuccessful(true);
        } else {
            $outcome->setPunishments($this->action->getPunishments());
            $outcome->setSuccessful(false);
        }

        return $outcome;
    }

    // @todo consider moving this to a calculator class
    public function getPercentageChance()
    {
        $skill = $this->player->getSkill(get_class($this->action));
        $actionChance = 1 - $this->action->getDifficulty();

        // @todo consider making this variable
        // $actionChance - random_int(0, $this->action->getDifficulty() * 100);

        // @todo round to 100
        return $skill * $actionChance * 100;
    }
}