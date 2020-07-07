<?php

namespace App\Game\Contracts;

interface PlayerRequired {

    public function asPlayer(PlayerContract $player);

    public function getPlayer() : ?PlayerContract;
}