<?php

namespace App\Game\Traits;

use App\Game\Contracts\PlayerContract;

trait InteractsAsPlayer {

    private $player;

    public function asPlayer(PlayerContract $player)
    {
        $this->player = $player;
    }

    /**
     * @return mixed
     */
    public function getPlayer() : ?PlayerContract
    {
        return $this->player;
    }
}