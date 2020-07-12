<?php

namespace App\RumRunning\Repositories;

use App\Game\Contracts\PlayerContract;
use App\Game\Contracts\TimerRepositoryContract;
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
     * TimerRepository constructor.
     * @param Timer $timerModel
     */
    public function __construct(Timer $timerModel)
    {
        $this->timerModel = $timerModel->newInstance();
    }

    public function forPlayer(PlayerContract $player): TimerRepositoryContract
    {
        $this->player = $player;

        return $this;
    }

    public function setUntil(string $timer, Carbon $carbon): void
    {
        $this->timerModel->updateOrCreate(
            ['user_id' => $this->player->getKey(), 'type' => $timer],
            ['ends_at' => $carbon]
        );
    }
}