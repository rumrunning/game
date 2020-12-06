<?php

namespace Tests\Unit\Game\ChanceCalculators;

use App\Game\ActionChanceOffsetCalculator;
use App\Game\ChanceCalculators\PlayerSkillSetChanceCalculator;
use App\Game\Claim;
use App\Game\ClaimCollection;
use App\RumRunning\Crimes\CrimeFactory;
use App\RumRunning\Rewards\Skill;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\Mock;
use Mockery\MockInterface;
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

        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([new Claim(new Skill(10))]);

        $player = $this->player();
        $action = $crimesCollection->first();
        $player->collectClaimsFor($action, $claimCollection);

        $calc = \Mockery::mock(PlayerSkillSetChanceCalculator::class, [$player])->makePartial();
        $calc->shouldAllowMockingProtectedMethods()
            ->shouldReceive('getRandomOffsetPercentage')->andReturn(0)
        ;

        $this->assertSame(0.1, $calc->getActionPercentage($crimesCollection->first()));
    }

    public function testGetActionPercentageRoundsTo100()
    {
        $this->seed();

        $crimesCollection = CrimeFactory::createFromArray($this->crimes());
        $claimCollection = new ClaimCollection([new Claim(new Skill(1500))]);

        $player = $this->player();
        $action = $crimesCollection->first();
        $player->collectClaimsFor($action, $claimCollection);

        $calc = \Mockery::mock(PlayerSkillSetChanceCalculator::class, [$player])->makePartial();
        $calc->shouldAllowMockingProtectedMethods()
            ->shouldReceive('getRandomOffsetPercentage')->andReturn(0)
        ;


        $this->assertSame(100.0, $calc->getActionPercentage($action));
    }
}
