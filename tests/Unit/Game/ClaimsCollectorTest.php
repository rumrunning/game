<?php

namespace Tests\Unit\Game;

use App\Game\Claim;
use App\Game\ClaimCollection;
use App\Game\ClaimsCollector;
use App\Game\Contracts\ActionContract;
use App\Game\Contracts\PlayerContract;
use App\RumRunning\Crimes\CrimeFactory;
use App\RumRunning\Rewards\Money;
use App\RumRunning\Rewards\Skill;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClaimsCollectorTest extends TestCase {

    use DatabaseMigrations, RefreshDatabase;

    private function player()
    {
        return User::first();
    }

    public function test__construct()
    {
        $this->seed();
        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([new Claim(new Skill(150))]);

        $player = $this->player();
        $action = $crimesCollection->first();

        $claimsCollector = new ClaimsCollector($claimCollection, $player, $action);

        $this->assertInstanceOf(ClaimsCollector::class, $claimsCollector);
    }

    public function testCollect()
    {
        $this->seed();
        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([
            new Claim(new Skill(150)),
            new Claim(new Money(1000)),
        ]);

        $player = $this->player();
        $action = $crimesCollection->first();

        (new ClaimsCollector($claimCollection, $player, $action))->collect();

        $this->assertSame(0.15, $player->getSkillSetPoints(get_class($action)));
        $this->assertSame(1000, $player->monies);
    }

    public function testCollectMoneyClaimForCrime()
    {
        $this->seed();
        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([new Claim(new Money(150))]);

        $player = $this->player();
        $action = $crimesCollection->first();

        (new ClaimsCollector($claimCollection, $player, $action))->collect();

        $this->assertSame(150, $player->monies);
    }

    public function testCollectSkillClaimForCrime()
    {
        $this->seed();
        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([new Claim(new Skill(150))]);

        $player = $this->player();
        $action = $crimesCollection->first();

        (new ClaimsCollector($claimCollection, $player, $action))->collect();

        $this->assertSame(0.15, $player->getSkillSetPoints(get_class($action)));
    }

    public function testGetPlayer()
    {
        $this->seed();
        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([new Claim(new Skill(150))]);

        $player = $this->player();
        $action = $crimesCollection->first();

        $claimsCollector = new ClaimsCollector($claimCollection, $player, $action);

        $this->assertInstanceOf(PlayerContract::class, $claimsCollector->getPlayer());
        $this->assertSame($player, $claimsCollector->getPlayer());
    }

    public function testGetAction()
    {
        $this->seed();
        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([new Claim(new Skill(150))]);

        $player = $this->player();
        $action = $crimesCollection->first();

        $claimsCollector = new ClaimsCollector($claimCollection, $player, $action);

        $this->assertInstanceOf(ActionContract::class, $claimsCollector->getAction());
        $this->assertSame($action, $claimsCollector->getAction());
    }
}
