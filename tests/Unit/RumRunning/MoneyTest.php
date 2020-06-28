<?php

namespace Tests\Unit\RumRunning;

use App\RumRunning\Rewards\Money;
use Tests\TestCase;

class MoneyTest extends TestCase {

    public function testCollect()
    {
        $money = new Money(10);

        $this->assertSame(10, $money->collect());
    }

    public function testCollectBetween()
    {
        $money = new Money(8, 10);
        $value = $money->collect();

        $this->assertContains($value, [8, 9, 10]);
    }
}
