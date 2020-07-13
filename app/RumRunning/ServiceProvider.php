<?php

namespace App\RumRunning;

use App\Game\Contracts\DiceContract;
use App\Game\Contracts\GameContract;
use App\RumRunning\Crimes\CrimeFactory;
use App\RumRunning\Crimes\CrimeCollection;
use App\RumRunning\Repositories\EloquentTimerRepository;
use App\Timer;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {

    public function boot()
    {
        $this->app->singleton(GameContract::class, function($app) {
            $game = new Game(
                config('app.name'),
                $app[DiceContract::class],
                new EloquentTimerRepository(new Timer(), config('game.timers'))
            );

            $game->setCrimes($this->getCrimes());

            return $game;
        });
    }

    private function getCrimes() : CrimeCollection
    {
        return CrimeFactory::createFromArray(config('game.crimes'));
    }

}