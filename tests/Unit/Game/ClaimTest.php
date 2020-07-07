<?php

namespace Tests\Unit\Game;

use App\Game\Claim;
use App\RumRunning\Rewards\Money;
use Tests\TestCase;

class ClaimTest extends TestCase {

    private function collectable()
    {
        return new Money(10);
    }

    public function test__construct()
    {
        $claim = new Claim($this->collectable());

        $this->assertInstanceOf(Claim::class, $claim);
    }

    public function testGetValue()
    {
        $claim = new Claim($this->collectable());

        $this->assertSame(10, $claim->getValue());
    }

    public function testGetValueIsInRange()
    {
        $claim = new Claim(new Money(13, 15));

        $this->assertContains($claim->getValue(), [13, 14, 15]);
    }

    public function testGetCollectable()
    {
        $collectable = $this->collectable();

        $claim = new Claim($collectable);

        $this->assertEquals($collectable, $claim->getCollectable());
    }
}
