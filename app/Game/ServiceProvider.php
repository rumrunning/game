<?php

namespace App\Game;

use App\Game\Contracts\DiceContract;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

    public function boot()
    {
        $this->app->bind(DiceContract::class, function () {
            return new Dice();
        });
    }

}