<?php

namespace Tests\Unit\Game;

use App\Game\Claim;
use App\Game\ClaimCollection;
use App\Game\Outcome;
use App\Game\Traits\InteractsWithGame;
use App\RumRunning\Rewards\Money;
use App\RumRunning\Rewards\Skill;
use Tests\TestCase;

class OutcomeTest extends TestCase {

    use InteractsWithGame;

    private function rewards()
    {
        return [
            new Money(50),
            new Skill(10)
        ];
    }

    private function punishments()
    {
        return [
            new Skill(50)
        ];
    }

    public function test__construct()
    {
        $outcome = new Outcome($this->game());

        $this->assertInstanceOf(Outcome::class, $outcome);
    }

    public function testSetRewards()
    {
        $outcome = new Outcome($this->game());

        $this->assertNull($outcome->setRewards($this->rewards()));
    }

    public function testSetPunishments()
    {
        $outcome = new Outcome($this->game());

        $this->assertNull($outcome->setPunishments($this->punishments()));
    }

    public function testSetSuccessful()
    {
        $outcome = new Outcome($this->game());

        $this->assertNull($outcome->setSuccessful(true));
        $this->assertTrue($outcome->wasSuccessful());
    }

    public function testSetSuccessfulFalse()
    {
        $outcome = new Outcome($this->game());

        $this->assertNull($outcome->setSuccessful(false));
        $this->assertNotTrue($outcome->wasSuccessful());
    }

    public function testClaims()
    {
        $rewards = $this->rewards();
        $punishments = $this->punishments();

        $outcome = new Outcome($this->game());

        $outcome->setRewards($rewards);
        $outcome->setPunishments($punishments);

        // Should only see punishments
        $claims = $outcome->claims();
        $this->assertInstanceOf(ClaimCollection::class, $claims);
        $this->assertCount(1, $claims);
        $this->containsOnlyInstancesOf(Claim::class, $claims);

        $skillClaim = $claims->first();
        $this->assertEquals(data_get($punishments, 0), $skillClaim->getCollectable());
        $this->assertSame(0.05, $skillClaim->getValue());
    }

    public function testSuccessfulClaims()
    {
        $rewards = $this->rewards();
        $punishments = $this->punishments();

        $outcome = new Outcome($this->game());

        $outcome->setSuccessful(true);
        $outcome->setRewards($rewards);
        $outcome->setPunishments($punishments);

        // Should see both money and skill rewards as the money chance of discovery is set to 1 (100%)
        $claims = $outcome->claims();

        $this->assertInstanceOf(ClaimCollection::class, $claims);
        $this->assertCount(2, $claims);
        $this->containsOnlyInstancesOf(Claim::class, $claims);

        $this->assertEquals(data_get($rewards, 0), $claims->first()->getCollectable());
        $this->assertEquals(data_get($rewards, 1), $claims->last()->getCollectable());
    }

    public function testWasSuccessful()
    {
        $outcome = new Outcome($this->game());

        $this->assertNull($outcome->setSuccessful(true));
        $this->assertTrue($outcome->wasSuccessful());
    }

    public function testWasSuccessfulDefaultFalse()
    {
        $outcome = new Outcome($this->game());

        $this->assertNotTrue($outcome->wasSuccessful());
    }
}
