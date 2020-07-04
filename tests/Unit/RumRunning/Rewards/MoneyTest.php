<?php

namespace Tests\Unit\RumRunning\Rewards;

use Mockery;
use Tests\TestCase;
use App\RumRunning\Rewards\Money;

class MoneyTest extends TestCase {

    public function test__constructor()
    {
        $skill = new Money(10);

        $this->assertInstanceOf(Money::class, $skill);
        $this->assertSame(10, $skill->collect());
    }

    public function test__constructorOptionalArgs()
    {
        $skill = new Money(10, 11);

        $this->assertInstanceOf(Money::class, $skill);
        $this->assertContains($skill->collect(), [10, 11]);
    }

    public function testCollect()
    {
        $this->partialMock(Money::class, function (Mockery\MockInterface $mock) {
            $mock->shouldAllowMockingProtectedMethods()
                ->shouldReceive('randomReward')
                ->andReturn(10)
            ;
        });

        $collected = $this->app->get(Money::class)->collect();

        $this->assertSame(10, $collected);
    }
}
