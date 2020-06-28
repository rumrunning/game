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
     * @param $chanceCalculators
     */
    public function __construct(string $name, DiceContract $dice, array $chanceCalculators)
    {
        $this->name = $name;
        $this->dice = $dice;
        $this->chanceCalculators = $chanceCalculators;
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

    public function defaultChanceCalculator(PlayerContract $player) : ChanceCalculatorContract
    {
        $chanceCalculatorClass = $this->chanceCalculators['default'];

        return new $chanceCalculatorClass($player);
    }

    protected function skilledAttemptBy(PlayerContract $player, ActionContract $action)
    {
        return new SkilledAttempt($this, $player, $action);
    }
}