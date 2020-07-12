<?php

namespace App\Game;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;
use App\Game\Contracts\DiceContract;
use App\Game\Contracts\GameContract;
use App\Game\Contracts\PlayerContract;
use App\Game\Contracts\TimerRepositoryContract;
use App\Game\Contracts\TimerRestrictedContract;
use Carbon\Carbon;

abstract class Game implements GameContract {

    private $name;

    private $dice;

    protected $timerRepo;

    /**
     * Game constructor.
     * @param $name
     * @param $dice
     */
    public function __construct(string $name, DiceContract $dice, TimerRepositoryContract $timerRepo)
    {
        $this->name = $name;
        $this->dice = $dice;

        $this->timerRepo = $timerRepo;
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

    public function startTimer(PlayerContract $player, string $timer, int $seconds)
    {
        $timerUntil = Carbon::now()->addSeconds($seconds);

        $this->timerRepo->forPlayer($player)->setUntil($timer, $timerUntil);
    }

    protected function beforeAttempt(PlayerContract $player, ActionContract $action)
    {

    }

    protected function afterAttempt(PlayerContract $player, ActionContract $action, Outcome $outcome)
    {
        $player->collectClaimsFor($action, $outcome->claims());

        if ($action instanceof TimerRestrictedContract) {
            $this->startTimer($player, $action->getTimer(), $action->getTimerDuration());
        }

        // @todo keep a log of events and their outcomes
    }

    protected function skilledAttemptBy(PlayerContract $player, ActionContract $action)
    {
        return new SkilledAttempt($this, $player, $action);
    }
}