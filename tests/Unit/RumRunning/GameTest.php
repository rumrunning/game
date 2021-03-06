<?php

namespace Tests\Unit\RumRunning;

use App\Game\Contracts\TimerModelContract;
use App\Game\Dice;
use App\Game\Outcome;
use App\RumRunning\Crimes\Crime;
use App\RumRunning\Crimes\CrimeFactory;
use App\RumRunning\Crimes\CrimeCollection;
use App\RumRunning\Game;
use App\RumRunning\Repositories\EloquentTimerRepository;
use App\Timer;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameTest extends TestCase {

    use DatabaseMigrations, RefreshDatabase;

    private function name()
    {
        return 'Rum Running';
    }

    private function dice()
    {
        return new Dice();
    }

    private function crimesCollection()
    {
        return new CrimeCollection();
    }

    private function timerRepo()
    {
        return new EloquentTimerRepository(new Timer(), [
            Crime::class
        ]);
    }

    private function game()
    {
        $game = new Game(
            $this->name(),
            $this->dice(),
            $this->timerRepo()
        );

        $game->setCrimes($this->crimesCollection());

        return $game;
    }

    public function test__construct()
    {
        $game = new Game(
            $this->name(),
            $this->dice(),
            $this->timerRepo()
        );

        $game->setCrimes($this->crimesCollection());

        $this->assertInstanceOf(Game::class, $game);
    }

    public function testStartTimer()
    {
        $game = new Game(
            $this->name(),
            $this->dice(),
            $this->timerRepo()
        );

        $startedTimer = $game->startTimer(factory(User::class)->create(), Crime::class, 60);
        $this->assertInstanceOf(TimerModelContract::class, $startedTimer);
    }

    public function testCrimes()
    {
        $game = $this->game();

        $this->assertInstanceOf(CrimeCollection::class, $game->crimes());
    }

    public function testAttemptCrime()
    {
        $this->seed();

        $crimeCollection = CrimeFactory::createFromArray($this->crimes());
        $player = User::first();

        $game = new Game(
            $this->name(),
            $this->dice(),
            $this->timerRepo()
        );

        $game->setCrimes($crimeCollection);

        $this->assertInstanceOf(Outcome::class, $game->attemptCrime($player, $crimeCollection->first()));
    }
}
