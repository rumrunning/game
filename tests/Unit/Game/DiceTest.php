<?php

namespace Tests\Unit\Game;

use App\Game\Dice;
use Tests\TestCase;

class DiceTest extends TestCase {

    public function testRoll()
    {
        $dice = new Dice();

        $result = $dice->roll(0, 100);

        $this->assertTrue(is_float($result));
    }
}
