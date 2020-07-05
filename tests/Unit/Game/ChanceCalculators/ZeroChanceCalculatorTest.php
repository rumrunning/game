<?php

namespace Tests\Unit\Game\ChanceCalculators;

use App\Game\ChanceCalculators\ZeroChanceCalculator;
use App\RumRunning\Crimes\CrimeFactory;

class ZeroChanceCalculatorTest extends TestCase {

    public function testGetActionPercentage()
    {
        $crimes = CrimeFactory::createFromArray($this->crimes());
        $calc = new ZeroChanceCalculator();

        $this->assertSame(0, $calc->getActionPercentage($crimes->first()));
    }
}
