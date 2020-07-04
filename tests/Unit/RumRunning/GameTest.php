<?php

namespace Tests\Unit\RumRunning;

use App\Game\Dice;
use App\RumRunning\Crimes\CrimesCollection;
use App\RumRunning\Game;
use Tests\TestCase;

class GameTest extends TestCase {

    private function name()
    {
        return 'Rum Running';
    }

    private function dice()
    {
        return new Dice();
    }

    private function chanceCalculators()
    {
        return ['default' => \App\Game\PlayerSkillSetChanceCalculator::class];
    }

    private function crimes()
    {
        [
            [
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
            ]
        ];
    }

    private function crimesCollection()
    {
        return new CrimesCollection();
    }

    private function game()
    {
        return new Game(
            $this->name(),
            $this->dice(),
            $this->chanceCalculators(),
            $this->crimesCollection()
        );
    }

    public function test__construct()
    {
        $game = new Game(
            $this->name(),
            $this->dice(),
            $this->chanceCalculators(),
            $this->crimesCollection()
        );

        $this->assertInstanceOf(Game::class, $game);
    }

    public function testCrimes()
    {
        $game = $this->game();

        $this->assertInstanceOf(CrimesCollection::class, $game->crimes());
    }

    public function testAttemptCrime()
    {

    }
}
