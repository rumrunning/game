<?php

namespace App\RumRunning;

use App\Game\Contracts\DiceContract;
use App\Game\Contracts\GameContract;
use App\RumRunning\Crimes\CrimeFactory;
use App\RumRunning\Crimes\CrimesCollection;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

    public function boot()
    {
        $this->app->singleton(GameContract::class, function($app) {
            return new Game(
                config('app.name'),
                $app[DiceContract::class],
                config('game.chance_calculators'),
                $this->getCrimes()
            );
        });
    }

    private function getCrimes() : CrimesCollection
    {
        return CrimeFactory::createFromArray(config('game.crimes'));
    }

}