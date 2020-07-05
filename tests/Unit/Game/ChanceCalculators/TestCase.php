<?php

namespace Tests\Unit\Game\ChanceCalculators;

use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {

    protected function crimes()
    {
        return [
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
}