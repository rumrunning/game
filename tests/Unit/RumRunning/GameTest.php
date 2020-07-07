<?php

namespace Tests\Unit\RumRunning;

use App\Game\ChanceCalculators\PlayerSkillSetChanceCalculator;
use App\Game\Dice;
use App\Game\Outcome;
use App\RumRunning\Crimes\CrimeFactory;
use App\RumRunning\Crimes\CrimesCollection;
use App\RumRunning\Game;
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

    private function chanceCalculators()
    {
        return ['default' => PlayerSkillSetChanceCalculator::class];
    }

    private function crimesCollection()
    {
        return new CrimesCollection();
    }

    private function game()
    {
        $game = new Game(
            $this->name(),
            $this->dice()
        );

        $game->setCrimes($this->crimesCollection());
        $game->setChanceCalculators($this->chanceCalculators());

        return $game;
    }

    public function test__construct()
    {
        $game = new Game(
            $this->name(),
            $this->dice()
        );

        $game->setCrimes($this->crimesCollection());
        $game->setChanceCalculators($this->chanceCalculators());

        $this->assertInstanceOf(Game::class, $game);
    }

    public function testCrimes()
    {
        $game = $this->game();

        $this->assertInstanceOf(CrimesCollection::class, $game->crimes());
    }

    public function testAttemptCrime()
    {
        $this->seed();

        $crimeCollection = CrimeFactory::createFromArray($this->crimes());
        $player = User::first();

        $game = new Game(
            $this->name(),
            $this->dice()
        );

        $game->setCrimes($crimeCollection);
        $game->setChanceCalculators($this->chanceCalculators());

        $this->assertInstanceOf(Outcome::class, $game->attemptCrime($player, $crimeCollection->first()));
    }
}
