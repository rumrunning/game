<?php

namespace Tests\Unit\Models;

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

    public function testStartWith0Monies()
    {
        $this->seed();

        $player = $this->player();

        $this->assertSame(0, $player->monies);
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

        $this->assertEquals(0.01, $player->getSkillSetPoints(Crime::class));
    }

    public function testGetSkillSet()
    {
        $this->seed();

        $player = $this->player();

        $this->assertInstanceOf(SkillSet::class, $player->getSkillSet(Crime::class));
    }

    public function testAttemptCrime()
    {
        $this->seed();

        $player = $this->player();
        $crime = $this->game()->crimes()->first();

        $this->assertInstanceOf(Outcome::class, $player->attemptCrime($crime));
    }

    public function testCollectSkillClaimForCrime()
    {
        $this->seed();
        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([new Claim(new Skill(150))]);

        $player = $this->player();
        $action = $crimesCollection->first();
        $player->collectClaimsFor($action, $claimCollection);

        $this->assertSame(1.51, $player->getSkillSetPoints(get_class($action)));
    }

    public function testCollectMoneyClaimForCrime()
    {
        $this->seed();
        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([new Claim(new Money(150))]);

        $player = $this->player();
        $action = $crimesCollection->first();
        $player->collectClaimsFor($action, $claimCollection);

        $this->assertSame(150, $player->monies);
    }

    public function testCollectClaimsForCrime()
    {
        $this->seed();
        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([
            new Claim(new Skill(150)),
            new Claim(new Money(1000)),
        ]);

        $player = $this->player();
        $action = $crimesCollection->first();
        $player->collectClaimsFor($action, $claimCollection);

        $this->assertSame(1.51, $player->getSkillSetPoints(get_class($action)));
        $this->assertSame(1000, $player->monies);
    }
}
