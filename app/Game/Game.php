<?php

namespace App\Game;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\DiceContract;
use App\Game\Contracts\GameContract;
use App\Game\Contracts\PlayerContract;

abstract class Game implements GameContract {

    /**
     * @return \App\Game\Contracts\DiceContract|mixed
     */
    public function dice()
    {
        return app(DiceContract::class);
    }

    protected function skilledAttemptBy(PlayerContract $player, ActionContract $action)
    {
        return new SkilledAttempt($this, $player, $action);
    }
}