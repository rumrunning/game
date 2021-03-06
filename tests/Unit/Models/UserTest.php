<?php

namespace Tests\Unit\Models;

use App\Game\ChanceCalculators\PlayerSkillSetChanceCalculator;
use App\Game\ChanceCalculators\ZeroChanceCalculator;
use App\Game\Claim;
use App\Game\ClaimCollection;
use App\Game\Outcome;
use App\Game\Traits\InteractsWithGame;
use App\RumRunning\Crimes\Crime;
use App\RumRunning\Crimes\CrimeFactory;
use App\RumRunning\Rewards\Money;
use App\RumRunning\Rewards\Skill;
use App\SkillSet;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase {

    use DatabaseMigrations, RefreshDatabase, InteractsWithGame;

    private function player()
    {
        return User::first();
    }

    public function test__construct()
    {
        $player = new User();

        $this->assertInstanceOf(
            PlayerSkillSetChanceCalculator::class, $player->getDefaultActionChanceCalculator()
        );
    }

    public function testStartWith0Monies()
    {
        $this->seed();

        $player = $this->player();

        $this->assertSame(0, $player->monies);
    }

    public function testTimers()
    {
        $this->seed();

        $player = $this->player();

        $this->assertInstanceOf(HasMany::class, $player->timers());
        $this->assertInstanceOf(Collection::class, $player->timers);
    }

    public function testSkillSets()
    {
        $this->seed();

        $player = $this->player();

        $this->assertInstanceOf(HasMany::class, $player->skillSets());
        $this->assertInstanceOf(Collection::class, $player->skillSets);
    }

    public function testGetSkillSetPoints()
    {
        $this->seed();

        $player = $this->player();

        $this->assertEquals(0, $player->getSkillSetPoints(Crime::class));
    }

    public function testGetSkillSet()
    {
        $this->seed();

        $player = $this->player();

        $this->assertInstanceOf(SkillSet::class, $player->getSkillSet(Crime::class));
    }

    public function testGetActionChanceCalculator()
    {
        $player = new User();

        $this->assertInstanceOf(
            PlayerSkillSetChanceCalculator::class, $player->getActionChanceCalculator(Crime::class)
        );
    }

    public function testGetDefaultActionChanceCalculator()
    {
        $player = new User();

        $this->assertInstanceOf(
            PlayerSkillSetChanceCalculator::class, $player->getActionChanceCalculator(Crime::class)
        );
    }

    public function testSetDefaultActionChanceCalculator()
    {
        $player = new User();

        $player->setDefaultActionChanceCalculator(new ZeroChanceCalculator());

        $this->assertInstanceOf(
            ZeroChanceCalculator::class, $player->getActionChanceCalculator(Crime::class)
        );
    }

    public function testAttemptCrime()
    {
        $this->seed();

        $player = $this->player();
        $crime = $this->game()->crimes()->first();

        $this->assertInstanceOf(Outcome::class, $player->attemptCrime($crime));
    }
}
