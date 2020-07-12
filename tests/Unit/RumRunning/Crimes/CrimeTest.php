<?php

namespace Tests\Unit\RumRunning\Crimes;

use App\RumRunning\Crimes\Crime;
use Tests\TestCase;

class CrimeTest extends TestCase {

    private function crimeProperties()
    {
        return data_get($this->crimes(), 0, null);
    }

    public function test__construct()
    {
        $crimeProps = $this->crimeProperties();

        $crime = new Crime(
            $crimeProps['code'],
            $crimeProps['description'],
            $crimeProps['difficulty'],
            $crimeProps['outcomes']
        );

        $this->assertInstanceOf(Crime::class, $crime);
    }

    public function testGetCode()
    {
        $crimeProps = $this->crimeProperties();

        $crime = new Crime(
            $crimeProps['code'],
            $crimeProps['description'],
            $crimeProps['difficulty'],
            $crimeProps['outcomes']
        );

        $this->assertSame($crimeProps['code'], $crime->getCode());
    }

    public function testGetDescription()
    {
        $crimeProps = $this->crimeProperties();

        $crime = new Crime(
            $crimeProps['code'],
            $crimeProps['description'],
            $crimeProps['difficulty'],
            $crimeProps['outcomes']
        );

        $this->assertSame($crimeProps['description'], $crime->getDescription());
    }

    public function testGetRewards()
    {
        $crimeProps = $this->crimeProperties();
        $rewards = $crimeProps['outcomes']['rewards'];

        $crime = new Crime(
            $crimeProps['code'],
            $crimeProps['description'],
            $crimeProps['difficulty'],
            $crimeProps['outcomes']
        );

        $crimeRewards = $crime->getRewards();
        $this->assertCount(2, $crimeRewards);

        $this->assertInstanceOf(\App\RumRunning\Rewards\Money::class, data_get($crimeRewards, 0));

        $this->assertInstanceOf(\App\RumRunning\Rewards\Skill::class, data_get($crimeRewards, 1));
    }

    public function testGetPunishments()
    {
        $crimeProps = $this->crimeProperties();

        $crime = new Crime(
            $crimeProps['code'],
            $crimeProps['description'],
            $crimeProps['difficulty'],
            $crimeProps['outcomes']
        );

        $crimeRewards = $crime->getPunishments();
        $this->assertCount(1, $crimeRewards);

        $this->assertInstanceOf(\App\RumRunning\Rewards\Skill::class, data_get($crimeRewards, 0));
    }

    public function testGetDifficulty()
    {
        $crimeProps = $this->crimeProperties();

        $crime = new Crime(
            $crimeProps['code'],
            $crimeProps['description'],
            $crimeProps['difficulty'],
            $crimeProps['outcomes']
        );

        $this->assertSame($crimeProps['difficulty'], $crime->getDifficulty());
    }

    public function testGetTimer()
    {
        $crimeProps = $this->crimeProperties();

        $crime = new Crime(
            $crimeProps['code'],
            $crimeProps['description'],
            $crimeProps['difficulty'],
            $crimeProps['outcomes']
        );

        $this->assertIsString($crime->getTimer());
        $this->assertSame(Crime::class, $crime->getTimer());
    }

    public function testGetTimerDuration()
    {
        $crimeProps = $this->crimeProperties();

        $crime = new Crime(
            $crimeProps['code'],
            $crimeProps['description'],
            $crimeProps['difficulty'],
            $crimeProps['outcomes']
        );

        $this->assertIsInt($crime->getTimerDuration());
        $this->assertSame(30, $crime->getTimerDuration());
    }
}
