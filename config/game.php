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
                    new \App\RumRunning\Rewards\Money(100, 200),
                    new \App\RumRunning\Rewards\Skill(15, 19),
                ],
                'punishments' => [
                    new \App\RumRunning\Rewards\Skill(5, 13)
                ]
            ],
        ],
        [
            'code' => 'state-bank',
            'description' => 'Steal from the State Bank',
            'difficulty' => 0.7,
            'outcomes' => [
                'rewards' => [
                    new \App\RumRunning\Rewards\Money(200, 300),
                    new \App\RumRunning\Rewards\Skill(20, 27),
                ],
                'punishments' => [
                    new \App\RumRunning\Rewards\Skill(2, 10)
                ]
            ],
        ],
        [
            'code' => 'federal-bank',
            'description' => 'Steal from the Federal Bank',
            'difficulty' => 1.4,
            'outcomes' => [
                'rewards' => [
                    new \App\RumRunning\Rewards\Money(500, 1000),
                    new \App\RumRunning\Rewards\Skill(30, 40),
                ],
                'punishments' => [
                    new \App\RumRunning\Rewards\Skill(1, 8)
                ]
            ],
        ]
    ]
];