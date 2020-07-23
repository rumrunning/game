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
            'difficulty' => 0.15,
            'outcomes' => [
                'rewards' => [
                    // There is a 100% chance of getting money when rewards are collected
                    new \App\RumRunning\Rewards\Money(50, 110),
                    new \App\RumRunning\Rewards\Skill(13, 17),

                    // @todo Implement this
                    // 10% chance of discovering them
                    // (new \App\RumRunning\Rewards\Bullet(1, 15))->setDiscoveryChance(0.1)
                ],
                'punishments' => [
                    new \App\RumRunning\Rewards\Skill(10, 15)
                ]
            ],
        ],
        [
            'code' => 'store',
            'description' => 'Steal from a store',
            'difficulty' => 0.325,
            'outcomes' => [
                'rewards' => [
                    // There is a 100% chance of getting money when rewards are collected
                    new \App\RumRunning\Rewards\Money(100, 200),
                    new \App\RumRunning\Rewards\Skill(15, 19),
                ],
                'punishments' => [
                    new \App\RumRunning\Rewards\Skill(5, 13)
                ]
            ],
        ]
    ]
];