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
            $game = new Game(
                config('app.name'),
                $app[DiceContract::class]
            );

            $game->setChanceCalculators($this->getChanceCalculators());
            $game->setCrimes($this->getCrimes());

            return $game;
        });
    }

    private function getChanceCalculators()
    {
        return config('game.chance_calculators');
    }

    private function getCrimes() : CrimesCollection
    {
        return CrimeFactory::createFromArray(config('game.crimes'));
    }

}