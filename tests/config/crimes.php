<?php

return [
    [
        'code' => 'pickpocket',
        'description' => 'Pick-pocket someone',
        'difficulty' => 0.1,
        'outcomes' => [
            'rewards' => [
                new \App\RumRunning\Rewards\Money(50, 110),
                new \App\RumRunning\Rewards\Skill(10, 30),
            ],
            'punishments' => [
                new \App\RumRunning\Rewards\Skill(10),
            ]
        ],
    ]
];
