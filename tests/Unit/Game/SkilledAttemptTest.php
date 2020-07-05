<?php

namespace Tests\Unit\Game;

use App\Game\ChanceCalculators\HundredChanceCalculator;
use App\Game\ChanceCalculators\ZeroChanceCalculator;
use App\Game\Outcome;
use App\Game\Traits\InteractsWithGame;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\TestCase;
use App\Game\SkilledAttempt;

class SkilledAttemptTest extends TestCase {

    use DatabaseMigrations, RefreshDatabase, InteractsWithGame;

    private function player()
    {
        return User::first();
    }

    public function test__construct()
    {
        $player = factory(User::class)->make();

        $skilledAttempt = new SkilledAttempt(
            $this->game(),
            $player,
            $this->game()->crimes()->first()
        );

        $this->assertInstanceOf(SkilledAttempt::class, $skilledAttempt);
    }

    public function testAttempt()
    {
        $this->seed();

        $skilledAttempt = new SkilledAttempt(
            $this->game(),
            $this->player(),
            $this->game()->crimes()->first()
        );

        $this->assertInstanceOf(Outcome::class, $skilledAttempt->attempt());
    }

    public function testSuccessfulAttempt()
    {
        $this->seed();
        $game = $this->game();
        $player = $this->player();

        $skilledAttempt = new SkilledAttempt(
            $game,
            $player,
            $game->crimes()->first()
        );

        $skilledAttempt->setChanceCalculator(new HundredChanceCalculator());

        $outcome = $skilledAttempt->attempt();

        $this->assertInstanceOf(Outcome::class, $outcome);
        $this->assertSame(true, $outcome->wasSuccessful());
    }

    public function testFailedAttempt()
    {
        $this->seed();
        $game = $this->game();
        $player = $this->player();

        $skilledAttempt = new SkilledAttempt(
            $game,
            $player,
            $game->crimes()->first()
        );

        $skilledAttempt->setChanceCalculator(new ZeroChanceCalculator());

        $outcome = $skilledAttempt->attempt();

        $this->assertInstanceOf(Outcome::class, $outcome);
        $this->assertSame(false, $outcome->wasSuccessful());
    }
}
