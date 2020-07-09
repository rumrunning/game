<?php

namespace App\Game;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\DiceContract;
use App\Game\Contracts\GameContract;
use App\Game\Contracts\PlayerContract;

abstract class Game implements GameContract {

    private $name;

    private $dice;

    private $chanceCalculators;

    /**
     * Game constructor.
     * @param $name
     * @param $dice
     */
    public function __construct(string $name, DiceContract $dice)
    {
        $this->name = $name;
        $this->dice = $dice;
    }

    public function name() : string
    {
        return $this->name;
    }

    /**
     * @return \App\Game\Contracts\DiceContract|mixed
     */
    public function dice() : DiceContract
    {
        return $this->dice;
    }

    protected function skilledAttemptBy(PlayerContract $player, ActionContract $action)
    {
        return new SkilledAttempt($this, $player, $action);
    }
}