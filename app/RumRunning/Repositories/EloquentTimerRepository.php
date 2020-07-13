<?php

namespace App\RumRunning\Repositories;

use App\Game\Contracts\PlayerContract;
use App\Game\Contracts\TimerModelContract;
use App\Game\Contracts\TimerRepositoryContract;
use App\Game\Exceptions\InvalidTimerException;
use App\Timer;
use Carbon\Carbon;

class EloquentTimerRepository implements TimerRepositoryContract {

    /**
     * @var PlayerContract $player
     */
    private $player;

    /**
     * @var Timer $timerModel
     */
    private $timerModel;

    /**
     * @var array $timers
     */
    private $timers;

    /**
     * TimerRepository constructor.
     * @param Timer $timerModel
     * @param array $timers
     */
    public function __construct(Timer $timerModel, array $timers)
    {
        $this->timerModel = $timerModel->newInstance();

        $this->timers = $timers;
    }

    public function forPlayer(PlayerContract $player): TimerRepositoryContract
    {
        $this->player = $player;

        return $this;
    }

    public function setUntil(string $timer, Carbon $carbon) : TimerModelContract
    {
        if (! $this->validateTimer($timer)) {
            throw new InvalidTimerException("The timer '$timer' is not configured for this game. Ensure it is added to the timer config array.");
        }

        return $this->timerModel->updateOrCreate(
            ['user_id' => $this->player->getKey(), 'type' => $timer],
            ['ends_at' => $carbon]
        );
    }

    private function validateTimer($timer) : bool
    {
        return in_array($timer, $this->timers);
    }

    public function getTimer(string $timer): ?TimerModelContract
    {
        $model = $this->timerModel->forPlayer($this->player)->type($timer)->first();

        return $model;
    }
}