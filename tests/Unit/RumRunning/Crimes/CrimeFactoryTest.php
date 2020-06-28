<?php

namespace Tests\Unit\RumRunning\Crimes;

use App\RumRunning\Crimes\Crime;
use App\RumRunning\Crimes\CrimeFactory;
use App\RumRunning\Crimes\CrimesCollection;
use Tests\TestCase;

class CrimeFactoryTest extends TestCase {

    public function testCreateFromArray()
    {
        $crimes = config('game.crimes');

        $crimesCollection = CrimeFactory::createFromArray($crimes);

        $this->assertInstanceOf(CrimesCollection::class, $crimesCollection);

        $this->assertCount(count($crimes), $crimesCollection);

        foreach ($crimes as $key => $crime) {
            $crimeModel = $crimesCollection->get($key);

            $this->assertInstanceOf(Crime::class, $crimeModel);
            $this->assertEquals($crime['code'], $crimeModel->getCode());
            $this->assertEquals($crime['description'], $crimeModel->getDescription());
            $this->assertCount(count($crime['outcomes']['rewards']), $crimeModel->getRewards());
            $this->assertCount(count($crime['outcomes']['punishments']), $crimeModel->getPunishments());
        }
    }
}
