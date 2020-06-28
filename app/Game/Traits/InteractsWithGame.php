<?php

namespace App\Game\Traits;

use App\Game\Contracts\GameContract;

trait InteractsWithGame {

    /**
     * @return \App\Game\Contracts\GameContract|mixed
     */
    private function game()
    {
        return app(GameContract::class);
    }
}