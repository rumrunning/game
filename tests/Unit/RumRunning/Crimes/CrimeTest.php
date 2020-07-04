<?php

namespace Tests\Unit\RumRunning\Crimes;

use App\RumRunning\Crimes\Crime;
use Tests\TestCase;

class CrimeTest extends TestCase {

    private function crimeProperties()
    {
        return [
            'code' => 'pickpocket',
            'description' => 'Pick-pocket someone',
            'difficulty' => 0.1,
            'outcomes' => [
                'rewards' => [
                    [
                        // There is a 100% chance of getting money when rewards are collected
                        'class' => new \App\RumRunning\Rewards\Money(50, 110),
                        'chance' => 1,
                    ],
                    [
                        'class' => new \App\RumRunning\Rewards\Skill(1, 3),
                        'chance' => 1,
                    ],
                ],
                'punishments' => [
                    [
                        'class' => new \App\RumRunning\Rewards\Skill(1),
                        'chance' => 1,
                    ],
                ]
            ],
        ];
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

        $this->assertInstanceOf(\App\RumRunning\Rewards\Money::class, data_get($crimeRewards, '0.class'));
        $this->assertSame(1, data_get($crimeRewards, '0.chance'));

        $this->assertInstanceOf(\App\RumRunning\Rewards\Skill::class, data_get($crimeRewards, '1.class'));
        $this->assertSame(1, data_get($crimeRewards, '1.chance'));
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

        $this->assertInstanceOf(\App\RumRunning\Rewards\Skill::class, data_get($crimeRewards, '0.class'));
        $this->assertSame(1, data_get($crimeRewards, '0.chance'));
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
}
