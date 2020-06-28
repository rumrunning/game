<?php

namespace App\RumRunning;

use App\Game\Contracts\GameContract;
use App\RumRunning\Crimes\CrimeFactory;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

    public function boot()
    {
        $crimes = CrimeFactory::createFromArray(config('game.crimes'));

        $this->app->singleton(GameContract::class, function() use ($crimes) {
            return new Game(
                config('app.name'),
                $crimes
            );
        });
    }

}