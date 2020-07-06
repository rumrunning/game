<?php

namespace Tests\Unit\Game\Traits;

use App\Game\Dice;
use App\Game\Traits\Discoverable;
use Mockery\MockInterface;
use Tests\TestCase;

class DiscoverableTest extends TestCase {

    public function testGetDiscoveryChance()
    {
        $discoverable = $this->getMockForTrait(Discoverable::class);

        $discoverable->setDiscoveryChance(1);

        $this->assertIsNumeric($discoverable->getDiscoveryChance());
        $this->assertEquals(100, $discoverable->getDiscoveryChance());
    }

    public function testSetDiscoveryChance()
    {
        $discoverable = $this->getMockForTrait(Discoverable::class);

        $setChance = $discoverable->setDiscoveryChance(0.5);

        $this->assertInstanceOf(get_class($discoverable), $setChance);
        $this->assertEquals(50, $discoverable->getDiscoveryChance());
    }

    public function testAttemptDiscovery()
    {
        $dice = $this->partialMock(Dice::class, function (MockInterface $mock) {
            $mock->shouldReceive('roll')->andReturn(100);
        });

        $discoverable = $this->getMockForTrait(Discoverable::class);

        $discoverable->setDiscoveryChance(1);
        $discoverable->attemptDiscovery($dice);

        $this->assertTrue($discoverable->wasDiscovered());
    }

    public function testFailedAttemptDiscovery()
    {
        $dice = $this->partialMock(Dice::class, function (MockInterface $mock) {
            $mock->shouldReceive('roll')->andReturn(15);
        });

        $discoverable = $this->getMockForTrait(Discoverable::class);

        $discoverable->setDiscoveryChance(0.1);
        $discoverable->attemptDiscovery($dice);

        $this->assertNotTrue($discoverable->wasDiscovered());
    }
}
