<?php

namespace Tests\Unit\RumRunning\Crimes;

use App\Game\Traits\InteractsWithGame;
use App\RumRunning\Crimes\CrimeFactory;
use App\RumRunning\Crimes\CrimesCollection;
use App\RumRunning\Crimes\Exceptions\NoSuchCrimeAvailable;
use Tests\TestCase;

class CrimesCollectionTest extends TestCase {

    use InteractsWithGame;

    public function testSelectException()
    {
        $this->expectException(NoSuchCrimeAvailable::class);

        $this->game()->crimes()->select('NOT_A_CRIME!');
    }

    public function testSelect()
    {
        $game = $this->game();
        $availableCrimes = CrimeFactory::createFromArray($this->crimes());
        $game->setCrimes($availableCrimes);

        $crime = $game->crimes()->select('pickpocket');

        $this->assertEquals($availableCrimes->first(), $crime);
    }
}
