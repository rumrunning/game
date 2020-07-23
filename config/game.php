<?php

return [
    'actions' => [
        'skilled' => [
            \App\RumRunning\Crimes\Crime::class,
        ]
    ],

    'timers' => [
        \App\RumRunning\Crimes\Crime::class
    ],

    'crimes' => [
        [
            'code' => 'pickpocket',
            'description' => 'Pick-pocket someone',
            'difficulty' => 0.1,
            'outcomes' => [
                'rewards' => [
                    // There is a 100% chance of getting money when rewards are collected
                    new \App\RumRunning\Rewards\Money(50, 110),
                    new \App\RumRunning\Rewards\Skill(7, 15),

                    // @todo Implement this
                    // 10% chance of discovering them
                    // (new \App\RumRunning\Rewards\Bullet(1, 15))->setDiscoveryChance(0.1)
                ],
                'punishments' => [
                    new \App\RumRunning\Rewards\Skill(1, 7)
                ]
            ],
        ],
        [
            'code' => 'store',
            'description' => 'Steal from a store',
            'difficulty' => 0.2,
            'outcomes' => [
                'rewards' => [
                    // There is a 100% chance of getting money when rewards are collected
                    new \App\RumRunning\Rewards\Money(100, 200),
                    new \App\RumRunning\Rewards\Skill(9, 17),
                ],
                'punishments' => [
                    new \App\RumRunning\Rewards\Skill(2, 7)
                ]
            ],
        ]
    ]
];