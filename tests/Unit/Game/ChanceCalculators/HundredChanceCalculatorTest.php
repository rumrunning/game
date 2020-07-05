<?php

namespace Tests\Unit\Game\ChanceCalculators;

use App\Game\ChanceCalculators\HundredChanceCalculator;
use App\RumRunning\Crimes\CrimeFactory;

class HundredChanceCalculatorTest extends TestCase {

    public function testGetActionPercentage()
    {
        $crimes = CrimeFactory::createFromArray($this->crimes());
        $calc = new HundredChanceCalculator();

        $this->assertSame(100, $calc->getActionPercentage($crimes->first()));
    }
}
