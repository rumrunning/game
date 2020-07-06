<?php

namespace Tests\Unit\Game\ChanceCalculators;

use App\Game\ChanceCalculators\PlayerSkillSetChanceCalculator;
use App\Game\Claim;
use App\Game\ClaimCollection;
use App\RumRunning\Crimes\CrimeFactory;
use App\RumRunning\Rewards\Skill;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerSkillSetChanceCalculatorTest extends TestCase {

    use DatabaseMigrations, RefreshDatabase;

    private function player()
    {
        return User::first();
    }

    public function test__construct()
    {
        $this->seed();

        $player = factory(User::class)->make();

        $calc = new PlayerSkillSetChanceCalculator($player);

        $this->assertInstanceOf(PlayerSkillSetChanceCalculator::class, $calc);
    }

    public function testGetActionPercentage()
    {
        $this->seed();

        $player = $this->player();
        $crimesCollection = CrimeFactory::createFromArray($this->crimes());

        $calc = new PlayerSkillSetChanceCalculator($player);

        $this->assertSame(0.9, $calc->getActionPercentage($crimesCollection->first()));
    }

    public function testGetActionPercentageRoundsTo100()
    {
        $this->seed();
        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([new Claim(new Skill(150))]);

        $player = $this->player();
        $action = $crimesCollection->first();
        $player->collectClaimsFor($action, $claimCollection);


        $calc = new PlayerSkillSetChanceCalculator($player);

        $this->assertSame(100, $calc->getActionPercentage($action));
    }
}
